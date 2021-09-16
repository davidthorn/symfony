<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * A Controller that manages an endpoint for an Entity.
 */
abstract class AbstractRestController extends AbstractFOSRestController
{
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
     * @return Response
     */
    public function index(): Response
    {
        return $this->json($this->all());
    }

    /**
     * @return Response
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

        if (!$item) {
            throw new NotFoundHttpException('The item does not exist');
        }

        $view = $this->view($item, Response::HTTP_OK, []);

        return $this->handleView($view);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function update(int $id): Response
    {
        $item = $this->loadEntity($id);

        if (!$item) {
            throw new NotFoundHttpException('The item does not exist');
        }

        return $this->handleForm($item);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $item = $this->loadEntity($id);

        if (!$item) {
            throw new NotFoundHttpException('The item does not exist');
        }

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
     */
    public function hasErrors(FormInterface $form): bool
    {
        $form->submit($this->request->request->all());

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
        $view = $this->view($form->getData(), $statusCode, $headers);
        return $this->handleView($view);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function loadEntity(int $id): mixed
    {
        return $this->getRepository()->find($id);
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
        return 'entity';
    }

    /**
     * @return mixed
     */
    public function createEntity(): mixed
    {
        $entity = $this->getEntityType();
        return new $entity;
    }

    /**
     * @param mixed $entity
     * @return Response
     */
    public function handleForm(mixed $entity): Response
    {
        $form = $this->buildForm($entity);

        if ($this->hasErrors($form)) {
            return $this->handleView($this->view($form));
        }

        $this->persistForm($form);

        return $this->response($form);
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
}