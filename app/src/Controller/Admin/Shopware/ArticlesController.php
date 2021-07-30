<?php

namespace App\Controller\Admin\Shopware;

use App\Entity\Shopware\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopware", name="shopware_")
 */
final class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        $all = $this->getDoctrine()->getManager('shopware')->getRepository(Article::class)->findAll();

        return $this->render('views/admin/shopware/articles/list.html.twig', [
            'articles' => $all
        ]);
    }
}