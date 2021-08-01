<?php

namespace App\Repository;

use App\Entity\Core\Menu;
use App\Interfaces\MenuRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuRepository extends ServiceEntityRepository implements MenuRepositoryInterface
{
    /**
     * MenuRepository constructor.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    private function manager(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }

    /**
     * @return \App\Entity\Core\Menu[]
     */
    public function all(): array
    {
        return $this->findAll();
    }

    /**
     * @param int $menu_id
     *
     * @return \App\Entity\Core\Menu|null
     */
    public function get(int $menu_id): ?Menu
    {
        return $this->find($menu_id);
    }

    /**
     * @param int $menu_id
     */
    public function delete(int $menu_id)
    {
        $entity = $this->find($menu_id);
        $this->manager()->remove($entity);
        $this->manager()->flush();
    }

    /**
     * Persists the menu.
     *
     * @param \App\Entity\Core\Menu $menu
     *
     * @return void
     */
    public function save(Menu $menu): void
    {
        $this->manager()->persist($menu);
        $this->manager()->flush();
    }

}
