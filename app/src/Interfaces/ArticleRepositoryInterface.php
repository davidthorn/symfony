<?php

namespace App\Interfaces;

/**
 * The interface that defines the articles repository.
 */
interface ArticleRepositoryInterface
{
    /**
     * Returns array of Articles
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function all(int $limit = 10, int $offset = 0): array;
}