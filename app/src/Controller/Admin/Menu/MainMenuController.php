<?php

namespace App\Controller\Admin\Menu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsible for delivering the admin menu for the views.
 *
 * Class MainMenuController
 *
 * @package App\Controller\Admin\Menu
 */
final class MainMenuController extends AbstractController
{
    /**
     * The path for the template that should be rendered.
     */
    private const TEMPLATE_NAME = 'includes/admin/sidebar.html.twig';

    /**
     * @param string $menuType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(string $menuType): Response
    {
        return $this->render(self::TEMPLATE_NAME, [
            'title' => $this->getTitle($menuType),
            'items' => $this->getItems($menuType)
        ]);
    }

    /**
     * Returns all items to be displayed on this menu.
     *
     * @param string $menuType
     *
     * @return array[]
     */
    private function getItems(string $menuType = 'default'): array
    {
        return match ($menuType) {
            'main' => [
                [
                    'link' => $this->generateUrl('app_admin_dashboard'),
                    'title' => 'Home'
                ],
                [
                    'link' => $this->generateUrl('app_admin_settings'),
                    'title' => 'Settings'
                ],
                [
                    'link' => $this->generateUrl('app_admin_users'),
                    'title' => 'Users'
                ]
            ],
            'account' => [
                [
                    'link' => $this->generateUrl('app_account_profile'),
                    'title' => 'Home'
                ]
            ],
            default => []
        };
    }

    /**
     * Returns the title for this menu.
     *
     * @param string $menuType
     *
     * @return string
     */
    private function getTitle(string $menuType): string
    {
        return match ($menuType) {
            'main' => 'Admin Main',
            'account' => 'Profile',
            default => 'No Name'
        };
    }
}