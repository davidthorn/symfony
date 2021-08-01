<?php

namespace App\Interfaces;

use App\Entity\Core\Menu;

/**
 * Interface MenuRepositoryInterface
 *
 * @package App\Interfaces
 */
interface MenuRepositoryInterface
{
    /**
     * Returns all Menus that are persisted.
     *
     * @return \App\Entity\Core\Menu[]
     */
    public function all(): array;

    /**
     * Delete the menu with the id if exists.
     *
     * @param int $menu_id
     */
    public function delete(int $menu_id);

    /**
     * Persists the menu.
     *
     * @param \App\Entity\Core\Menu $menu
     *
     * @return void
     */
    public function save(Menu $menu): void;

    /**
     * Return a Menu with this id if one can be found.
     *
     * @param int $menu_id
     *
     * @return \App\Entity\Core\Menu|null
     */
    public function get(int $menu_id): ?Menu;
}