<?php

namespace App\Interfaces;

/**
 * The interface that defines the orders repository.
 */
interface OrderRepositoryInterface
{
    /**
     * Returns array of Orders
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function all(int $limit = 10, int $offset = 0): array;
}