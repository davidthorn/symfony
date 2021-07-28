<?php

namespace App\Controller\Frontend\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 *
 * @package App\Controller\Frontend\Account
 */
final class ProfileController extends AbstractController
{
    /**
     * @Route("", name="profile", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return $this->render('views/account/profile.html.twig', [
            'data' => []
        ]);
    }
}