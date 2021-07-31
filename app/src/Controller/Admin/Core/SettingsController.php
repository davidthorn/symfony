<?php

namespace App\Controller\Admin\Core;

use App\Security\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SettingsController
 *
 * @package App\Controller\Admin
 */
final class SettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="settings", methods={"GET"})
     *
     */
    public function indexAction(): Response
    {
        $this->denyAccessUnlessGranted(Roles::ADMIN);
        return $this->render('views/admin/settings.html.twig', []);
    }
}