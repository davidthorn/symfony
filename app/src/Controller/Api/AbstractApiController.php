<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private Request $request;

    /**
     * AbstractApiController constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();

        if($this->request->headers->get('Content-Type') == 'application/json') {
            $this->request->request->replace(json_decode($this->request->getContent(), true));
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @Route(name="list", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    abstract public function listAction(): JsonResponse;

    /**
     * @Route("/{id}, name="read", methods={"GET"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    abstract public function getAction(int $id): JsonResponse;

    /**
     * @Route(name="create", methods={"POST"})
     *
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    abstract public function postAction(): JsonResponse;

    /**
     * @Route("/{id<\d+>?}", name="update", methods={"PUT"})
     *
     * @param int $id
     *
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    abstract public function putAction(int $id): JsonResponse;

    /**
     * @Route("/{id}, "name="delete", methods={"DELETE"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    abstract public function deleteAction(int $id): JsonResponse;
}