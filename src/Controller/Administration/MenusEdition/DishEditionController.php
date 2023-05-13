<?php

namespace App\Controller\Administration\MenusEdition;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DishEditionController extends AbstractController
{
    #[Route('/administration/publier-menus/editer-plat-{id}', name: 'app_administration_editer-plat', methods: 'POST')]
    public function editDish(Request $request, DishRepository $dishRepository, int $id): Response
    {
        $dish = $dishRepository->find($id);
        $editDishForm = $this->createForm(DishType::class, $dish, [
            'action' => $this->generateUrl('app_administration_editer-plat', ['id' => $id])
        ]);
        $editDishForm->handleRequest($request);

        if ($editDishForm->isSubmitted() && $editDishForm->isValid()) {
            $dish = $editDishForm->getData();
            $dishRepository->save($dish, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }

        return $this->render('/fragments/form/_dish_form.html.twig',
            [
                'editDishForm' => $editDishForm,
            ]
        );
    }

    #[Route('/administration/publier-menus/supprimer-plat/{id}', name: 'app_administration_supprimer-plat', methods: 'POST')]
    public function removeMenu(DishRepository $dishRepository, Dish $id): Response
    {
        $dishRepository->remove($id, true);
        return new Response(null, 204);
    }
}