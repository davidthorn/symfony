<?php

namespace App\Repository;

use App\Entity\Shopware\Article;
use App\Interfaces\ArticleRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends EntityRepository implements  ArticleRepositoryInterface
{
    /**
     * @param \Doctrine\ORM\EntityManagerInterface $shopwareEntityManager
     */
    public function __construct(EntityManagerInterface $shopwareEntityManager)
    {
        parent::__construct($shopwareEntityManager, $shopwareEntityManager->getClassMetadata(Article::class));
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
            ->select(['p.id', 'p.name', 'p.active'])
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}