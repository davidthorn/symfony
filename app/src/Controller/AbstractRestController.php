<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use HttpRequestMethodException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * A Controller that manages an endpoint for an Entity.
 */
abstract class AbstractRestController extends AbstractFOSRestController
{
    /**
     * The alias used for all query builders aliases.
     */
    public const ENTITY_ALIAS = 'entity';

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return string
     */
    abstract public function getFormType(): string;

    /**
     * @return string
     */
    abstract public function getEntityType(): string;

    /**
     * @return ObjectRepository
     */
    abstract public function getRepository(): ObjectRepository;

    /**
     * @return Request
     */
    public function getRequest(): Request {
        return $this->request;
    }

    /**
     * The method should be used for all rest resources that extend this class.
     * This method will handle all rest related requests for the entity and form defined in the
     * abstract methods.
     * The other help methods should be used to manipulate the response or entity etc.
     *
     * @throws HttpRequestMethodException
     */
    public function entryPoint(): Response
    {
        try {
            $method = $this->request->getMethod();
            $id = $this->request->attributes->get('id');

            return match ($method) {
                Request::METHOD_GET => $id === null ? $this->index() : $this->forceIdExists('item'),
                Request::METHOD_POST => $this->create(),
                Request::METHOD_PUT => $this->forceIdExists('update'),
                Request::METHOD_DELETE => $this->forceIdExists('delete'),
                default => throw new HttpRequestMethodException(),
            };
        } catch(Exception $exception) {
            $this->didThrownException($exception);
            throw $exception;
        }
    }

    /**
     * @param string $method
     * @return Response
     */
    private function forceIdExists(string $method): Response {
        $id = $this->request->attributes->get('id');
        $id = empty($id) ? null: $id;

        if($id === null) {
            throw new BadRequestHttpException('An id attribute is required for this request.');
        }

        return $this->{$method}($id);
    }


    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->willSendResponse($this->json($this->all()));
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function create(): Response
    {
        $entity = $this->createEntity();
        return $this->handleForm($entity);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function item(int $id): Response
    {
        $item = $this->loadEntity($id);
        $this->didLoadEntity($item);
        $view = $this->view($item, Response::HTTP_OK, []);
        return $this->willSendResponse($this->handleView($view));
    }

    /**
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function update(int $id): Response
    {
        $item = $this->loadEntity($id);
        $this->didLoadEntity($item);
        return $this->handleForm($item);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $item = $this->loadEntity($id);
        $entity = $this->willRemoveEntity($item);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        $this->didRemoveEntity($entity);

        $view = $this->view(null, Response::HTTP_NO_CONTENT);
        return $this->handleView($view);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function all(
        int   $limit = null,
        int   $offset = null): array
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select([$this->queryAlias()])
            ->from($this->getEntityType(), $this->queryAlias())
            ->setMaxResults($this->request->get('limit', $limit))
            ->setFirstResult($this->request->get('offset', $offset));

        return $this->willExecuteQueryBuilder($qb)->getQuery()->getResult();
    }

    /**
     * @param mixed $data
     * @param array $options
     * @return FormInterface
     */
    public function buildForm(mixed $data, array $options = []): FormInterface
    {
        $options['csrf_protection'] = false;

        /** @var FormInterface $form */
        return $this->get('form.factory')->createNamed('', $this->getFormType(), $data, $options);
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws Exception
     */
    public function hasErrors(FormInterface $form): bool
    {
        $preCheck = $this->request->request->all();
        $bodyParams = $this->willSubmitForm($preCheck);
        if($preCheck !== $this->request->request->all()) {
            throw new Exception('The will submit form should not make changes to the request');
        }
        $form->submit($bodyParams);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $form
     */
    public function persistForm(FormInterface $form)
    {
        $entity = $this->willPersistEntity($form->getData());
        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();
        $this->didPersistEntity($entity);
    }

    /**
     * @param FormInterface $form
     * @param int $statusCode
     * @param array $headers
     * @return Response
     */
    public function response(FormInterface $form, int $statusCode = Response::HTTP_OK, array $headers = []): Response
    {
        $view = $this->view($form->getData());
        $response = $this->handleView($view);
        // Updated status code and headers here to circumvent what fos people think status codes should be.
        $response->setStatusCode($statusCode);
        $response->headers->add($headers);
        return $this->willSendResponse($response);
    }

    /**
     * Must return an entity that has the matching id.
     * This method should be overridden if any changes are needed to be made to the entity
     * prior to it being used for the request.
     *
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function loadEntity(int $id): mixed
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            $message = sprintf('The entity: %s with id %d does not exist', $this->getEntityType(), $id);
            throw new NotFoundHttpException($message);
        }

        return $entity;
    }

    /**
     * Called directly after the loadEntity method has successfully returned an entity from the database.
     *
     * @param mixed $entity
     */
    public function didLoadEntity(mixed $entity) {
        // Override this method if any changes should be made to the entity.
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    public function willExecuteQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder {
        return $queryBuilder;
    }

    /**
     * @return string
     */
    public function queryAlias(): string {
        return self::ENTITY_ALIAS;
    }

    /**
     * Returns an entity that does not exist in the database.
     * This entity will be used for all POST requests, or simply said only when a new entity is being created.
     *
     * @return mixed
     */
    public function createEntity(): mixed
    {
        $entity = $this->getEntityType();
        return new $entity;
    }

    /**
     * @param mixed $entity
     * @param int $statusCode
     * @param array $headers
     * @return Response
     * @throws Exception
     */
    public function handleForm(mixed $entity, int $statusCode = Response::HTTP_OK, array $headers = []): Response
    {
        $form = $this->buildForm($entity);

        if ($this->hasErrors($form)) {
            $response = $this->handleView($this->view($form));
            $response->headers->add($headers);
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            return $this->willSendResponse($response);
        }

        $this->persistForm($form);

        return $this->willSendResponse($this->response($form, $statusCode, $headers));
    }

    /**
     * Method is called immediately prior to the entity being removed.
     *
     * @param mixed $entity
     * @return mixed
     */
    public function willRemoveEntity(mixed $entity): mixed {
        return $entity;
    }

    /**
     * Method is called immediately after the entity has been removed.
     *
     * @param mixed $entity
     */
    public function didRemoveEntity(mixed $entity) {
        // Method should be overridden to view the state of the entity after being removed.
    }

    /**
     * Method will be called prior to the entity being persisted.
     *
     * @param mixed $entity
     * @return mixed
     */
    public function willPersistEntity(mixed $entity): mixed {
        return $entity;
    }

    /**
     * Method should be overridden to view the state of the entity after being persisted.
     *
     * @param mixed $entity
     */
    public function didPersistEntity(mixed $entity) {
        // Method should be overridden to view the state of the entity after being persisted.
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function willSendResponse(Response $response): Response {
        return $response;
    }

    /**
     * Called immediately prior to the form being submitted using the requests body.
     */
    public function willSubmitForm(array $bodyParams): array {
        // Add, remove or update any request body params that will be submitted in the form.
        return $bodyParams;
    }

    /**
     * Called immediately after an exception has been thrown during the creation of a response.
     * This method is the sad-case for willSendResponse.
     *
     * @param mixed $exception
     */
    public function didThrownException(mixed $exception) {
        // Use this method to handle or log any exceptions.
    }
}