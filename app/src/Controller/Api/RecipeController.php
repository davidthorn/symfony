<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecipeController
 *
 * @Route("/recipes", name="recipes_", host="localhost")
 *
 * @package App\Controller
 */
final class RecipeController extends AbstractApiController
{
    /**
     * @Route("/{id<\d+>}", name="read", methods={"GET"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(int $id): JsonResponse
    {
        return $this->json([
            'item_id' => $id
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/{uid<[a-zA-Z\d-]+>}", name="read_uid", methods={"GET"})
     *
     * @param string $uid
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUIDAction(string $uid): JsonResponse
    {
        return $this->json([
            'item_uid' => $uid
        ], Response::HTTP_OK);
    }

    /**
     * @Route(name="list", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction(): JsonResponse
    {
        return $this->json([
            'list' => []
        ], Response::HTTP_OK);
    }

    /**
     * @Route(name="create", methods={"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postAction(): JsonResponse
    {
        return $this->json([
            'data' => $this->getRequest()->request->all(),
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id<\d+>?}", name="update", methods={"PUT"})
     *
     * @param ?int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function putAction(?int $id): JsonResponse
    {
        return $this->json([
            'item_put' => $id ?? $this->getRequest()->request->get('id', $id),
            'item_body' => $this->getRequest()->request->all(),
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"DELETE"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction(int $id): JsonResponse
    {
        return $this->json([
            'item_id_deleted' => $id
        ], Response::HTTP_OK);
    }
}