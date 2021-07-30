<?php

namespace App\Services;

use App\Entity\Menu;
use App\Interfaces\MenuRepositoryInterface;
use App\Interfaces\MenusServiceInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class MenusService
 *
 * @package App\Services
 */
final class MenusService implements MenusServiceInterface
{
    /**
     * @var \App\Interfaces\MenuRepositoryInterface
     */
    protected MenuRepositoryInterface $menuRepository;

    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * MenusService constructor.
     *
     * @param \App\Interfaces\MenuRepositoryInterface $menuRepository
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
     */
    public function __construct(MenuRepositoryInterface $menuRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->menuRepository = $menuRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return array
     */
    public function listData(): array
    {
        $menus = $this->all();

        return [
            'menus' => $menus,
            'edit_links' => array_map(function($menu) {
                return $this->urlGenerator->generate(self::EDIT_ROUTE, [ 'menu_id' => $menu->getId() ]);
            }, $menus),
            'delete_links' => array_map(function($menu) {
                return $this->urlGenerator->generate(self::DELETE_ROUTE, [ 'menu_id' => $menu->getId() ]);
            }, $menus)
        ];
    }

    /**
     * @return \App\Entity\Menu[]
     */
    public function all(): array
    {
        return $this->menuRepository->all();
    }

    /**
     * @param int $menu_id
     *
     * @return \App\Entity\Menu|null
     */
    public function get(int $menu_id): ?Menu
    {
        return $this->menuRepository->get($menu_id);
    }

    /**
     * @param int $menu_id
     */
    public function delete(int $menu_id)
    {
        $this->menuRepository->delete($menu_id);
    }

    /**
     * @param \App\Entity\Menu $menu
     */
    public function save(Menu $menu): void
    {
        $this->menuRepository->save($menu);
    }
}