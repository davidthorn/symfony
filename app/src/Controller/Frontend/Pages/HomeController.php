<?php

namespace App\Controller\Frontend\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 *
 * @package App\Controller\Frontend
 */
final class HomeController extends AbstractController
{

    /**
     * @Route("", name="home", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return $this->render('views/pages/home.html.twig', [
            'data' => []
        ]);
    }

}