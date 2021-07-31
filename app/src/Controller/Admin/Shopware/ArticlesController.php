<?php

namespace App\Controller\Admin\Shopware;

use App\Entity\Shopware\Article;
use App\Interfaces\ArticleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles", name="articles_")
 */
final class ArticlesController extends AbstractController
{
    /**
     * @var \App\Interfaces\ArticleRepositoryInterface
     */
    protected ArticleRepositoryInterface $articleRepository;

    /**
     * @param \App\Interfaces\ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route(name="list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        $all = $this->articleRepository->all(10, 5);

        return $this->render('views/admin/shopware/articles/list.html.twig', [
            'articles' => $all
        ]);
    }
}