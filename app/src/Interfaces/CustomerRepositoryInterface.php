<?php

namespace App\Interfaces;

/**
 * The interface that defines the customers' repository.
 */
interface CustomerRepositoryInterface
{
    /**
     * Returns array of Customers
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function all(int $limit = 10, int $offset = 0): array;
}