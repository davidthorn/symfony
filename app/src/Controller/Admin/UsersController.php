<?php

namespace App\Controller\Admin;

use App\Security\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
USE Symfony\Component\Routing\Annotation\Route;

/**
 * The controller used to display all users that are registered with the app.
 * A user is not a customer, customers will fall under another topic.
 *
 * Class UserListController
 *
 * @package App\Controller\Admin
 */
final class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users", methods={"GET"})
     *
     */
    public function indexAction(): Response
    {
        $this->denyAccessUnlessGranted(Roles::SUPER_ADMIN);
        return $this->render('views/admin/users.html.twig', []);
    }
}