<?php

namespace App\Interfaces;

use App\Entity\Menu;
use App\Services\MenusService;

/**
 * Interface MenusServiceInterface
 *
 * @package App\Interfaces
 */
interface MenusServiceInterface
{
    /** CONSTANTS */
    public const LIST_ROUTE = 'app_admin_menus_list';
    public const EDIT_ROUTE = 'app_admin_menus_edit';
    public const DELETE_ROUTE = 'app_admin_menus_delete';
    public const LIST_VIEW = 'views/admin/menus/list.html.twig';
    public const FORM_VIEW = 'views/admin/menus/form.html.twig';

    /**
     * Returns all Menus that are persisted.
     *
     * @return \App\Entity\Menu[]
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
     * @param \App\Entity\Menu $menu
     *
     * @return void
     */
    public function save(Menu $menu): void;

    /**
     * Return a Menu with this id if one can be found.
     *
     * @param int $menu_id
     *
     * @return \App\Entity\Menu|null
     */
    public function get(int $menu_id): ?Menu;

    /**
     * @return array
     */
    public function listData(): array;
}