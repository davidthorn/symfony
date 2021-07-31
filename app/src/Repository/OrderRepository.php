<?php

namespace App\Repository;

use App\Entity\Shopware\Customer;
use App\Entity\Shopware\Order;
use App\Interfaces\OrderRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{
    /**
     * @param \Doctrine\ORM\EntityManagerInterface $shopwareEntityManager
     */
    public function __construct(EntityManagerInterface $shopwareEntityManager)
    {
        parent::__construct($shopwareEntityManager, $shopwareEntityManager->getClassMetadata(Order::class));
    }

    /**
     * Returns array of Articles
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function all(int $limit = 10, int $offset = 0): array
    {
        return $this->createQueryBuilder('p')
            ->select('p, c', 'd')
            ->innerJoin('p.customer', 'c')
            ->innerJoin('p.details', 'd')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('p.status >= 0')
            ->orderBy('p.orderTime', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
