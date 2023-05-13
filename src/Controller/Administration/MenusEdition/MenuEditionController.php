<?php

namespace App\Controller\Administration\MenusEdition;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuEditionController extends AbstractController
{
    #[Route('/administration/publier-menus/editer-menu/{id}', name: 'app_administration_editer-menu', methods: 'POST')]
    public function editMenu(Request $request, MenuRepository $menuRepository, ?int $id ): Response
    {
        $menu = $menuRepository->find($id);

        $editMenuForm = $this->createForm(MenuType::class, $menu, [
            'action' => $this->generateUrl('app_administration_editer-menu', ['id' => $id])
        ]);
        $editMenuForm->handleRequest($request);

        if ($editMenuForm->isSubmitted() && $editMenuForm->isValid()) {
            $menu = $editMenuForm->getData();
            $menuRepository->save($menu, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }

        return $this->render('/fragments/form/_menu_form.html.twig',
            [
                'editMenuForm' => $editMenuForm,
            ]
        );
    }

    #[Route('/administration/publier-menus/supprimer-menu/{id}', name: 'app_administration_supprimer-menu', methods: 'POST')]
    public function removeMenu(MenuRepository $menuRepository, Menu $id): Response
    {
        $menuRepository->remove($id, true);
        return new Response(null, 204);
    }
}