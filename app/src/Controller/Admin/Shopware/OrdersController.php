<?php

namespace App\Controller\Admin\Shopware;

use App\Interfaces\OrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopware", name="shopware_")
 */
final class OrdersController extends AbstractController
{
    /**
     * @var \App\Interfaces\OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $ordersRepository;

    /**
     * @param \App\Interfaces\OrderRepositoryInterface $ordersRepository
     */
    public function __construct(OrderRepositoryInterface $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * @Route("/orders", name="orders_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        $all = $this->ordersRepository->all(10, 0);

        return $this->render('views/admin/shopware/orders/list.html.twig', [
            'models' => $all
        ]);
    }
}