<?php

namespace App\Controller\Frontend\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccessDeniedController
 *
 * @package App\Controller\Frontend\Pages
 */
final class AccessDeniedController extends AbstractController
{
    /**
     * @Route("/access_denied", name="access_denied", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return $this->render('security/denied.html.twig', [
            'data' => []
        ]);
    }
}