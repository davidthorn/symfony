<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Menu;
use App\Form\MenuCreateFormType;
use App\Interfaces\MenusServiceInterface;
use App\Security\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The controller that is responsible for the creating, editing, removing menus.
 *
 * Class MenusController
 * @Route("/menus", name="menus_")
 *
 * @package App\Controller\Admin
 */
final class MenusController extends AbstractController
{
    /**
     * @var \App\Interfaces\MenusServiceInterface
     */
    protected MenusServiceInterface $menusService;

    /**
     * MenusController constructor.
     *
     * @param \App\Interfaces\MenusServiceInterface $menusService
     */
    public function __construct(MenusServiceInterface $menusService)
    {
        $this->menusService = $menusService;
    }

    /**
     * @Route("/add", name="add", methods={"GET"})
     *
     */
    public function addAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted(Roles::ADMIN);
        return $this->handleEditRequest(new Menu(), $request);
    }

    /**
     * @Route("/add", name="save", methods={"POST"})
     *
     */
    public function saveAction(Request $request): Response
    {
        return $this->addAction($request);
    }

    /**
     * @Route("", name="list", methods={"GET"})
     *
     */
    public function indexAction(): Response
    {
        $this->denyAccessUnlessGranted(Roles::ADMIN);
        return $this->render($this->menusService::LIST_VIEW, $this->menusService->listData());
    }

    /**
     * @Route("/edit/{menu_id}", name="edit", methods={"GET"})
     *
     */
    public function editAction(int $menu_id, Request $request): Response
    {
        return $this->updateAction($menu_id, $request);
    }

    /**
     * @Route("/edit/{menu_id}", name="update", methods={"PUT"})
     *
     */
    public function updateAction(int $menu_id, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Roles::ADMIN);
        $dto = $this->menusService->get($menu_id);
        return $this->handleEditRequest($dto, $request, Request::METHOD_PUT);
    }

    /**
     * @Route("/delete/{menu_id}", name="delete", methods={"DELETE"})
     *
     */
    public function deleteAction(int $menu_id): Response
    {
        $this->denyAccessUnlessGranted(Roles::ADMIN);
        $this->menusService->delete($menu_id);
        return $this->redirectToList();
    }

    /**
     * @param \App\Entity\Core\Menu $menu
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $method
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function handleEditRequest(Menu $menu, Request $request, string $method = Request::METHOD_POST): Response
    {
        // just setup a fresh $task object (remove the example data)
        $form = $this->createForm(MenuCreateFormType::class, $menu, [
            'method' => $method
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->menusService->save($form->getData());
            return $this->redirectToList();
        }

        return $this->render($this->menusService::FORM_VIEW, [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function redirectToList(): RedirectResponse
    {
        return $this->redirectToRoute($this->menusService::LIST_ROUTE);
    }
}