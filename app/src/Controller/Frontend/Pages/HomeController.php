<?php

namespace App\Controller\Frontend\Pages;

use App\Interfaces\HomeViewModelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Security\Roles;
/**
 * Class HomeController
 *
 * @package App\Controller\Frontend
 */
final class HomeController extends AbstractController
{
    /**
     * @var \App\Interfaces\HomeViewModelInterface
     */
    protected HomeViewModelInterface $viewModel;

    /**
     * HomeController constructor.
     *
     * @param \App\Interfaces\HomeViewModelInterface $viewModel
     */
    public function __construct(HomeViewModelInterface $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     * @Route("", name="home", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return $this->render('views/pages/home.html.twig', [
            'data' => [],
            'showAdmin' => $this->viewModel->isAdmin(),
            'login_text' => $this->viewModel->getLoginButtonText()
        ]);
    }

}