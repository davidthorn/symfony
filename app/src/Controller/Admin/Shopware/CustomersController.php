<?php

namespace App\Controller\Admin\Shopware;

use App\Interfaces\CustomerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customers", name="customers_")
 */
final class CustomersController extends AbstractController
{
    /**
     * @var \App\Interfaces\CustomerRepositoryInterface
     */
    protected CustomerRepositoryInterface $customersRepository;

    /**
     * @param \App\Interfaces\CustomerRepositoryInterface $customersRepository
     */
    public function __construct(CustomerRepositoryInterface $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    /**
     * @Route(name="list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        $all = $this->customersRepository->all(10, 0);

        return $this->render('views/admin/shopware/customers/list.html.twig', [
            'models' => $all
        ]);
    }
}