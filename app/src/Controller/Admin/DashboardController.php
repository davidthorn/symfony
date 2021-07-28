<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The controller that handles all requests for the administration area.
 *
 * Class DashboardController
 *
 * @package App\Controller\Admin
 */
class DashboardController extends AbstractController
{
    /**
     * @Route(name="dashboard")
     *
     */
    public function indexAction(): Response
    {
        return $this->render('views/admin/dashboard.html.twig', []);
    }
}