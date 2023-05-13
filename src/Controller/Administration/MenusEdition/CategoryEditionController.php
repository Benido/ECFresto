<?php

namespace App\Controller\Administration\MenusEdition;

use App\Entity\DishCategory;
use App\Form\DishCategoryType;
use App\Repository\DishCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryEditionController extends AbstractController
{
    #[Route('/administration/publier-menus/editer-categorie-{id}', name: 'app_administration_editer-categorie', methods: 'POST')]
    public function editCategory(Request $request, DishCategoryRepository $categoryRepository, ?int $id): Response
    {
        $category = $categoryRepository->find($id);
        $editCategoryForm = $this->createForm(DishCategoryType::class, $category, [
            'action' => $this->generateUrl('app_administration_editer-categorie', ['id' => $id])
        ]);
        $editCategoryForm->handleRequest($request);

        if ($editCategoryForm->isSubmitted() && $editCategoryForm->isValid()) {
            $category = $editCategoryForm->getData();
            $categoryRepository->save($category, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }

        return $this->render('/fragments/form/_category_form.html.twig',
            [
                'editCategoryForm' => $editCategoryForm,
            ]
        );
    }

    #[Route('/administration/publier-menus/supprimer-categorie/{id}', name: 'app_administration_supprimer-categorie', methods: 'POST')]
    public function removeMenu(DishCategoryRepository $categoryRepository, DishCategory $id): Response
    {
        $categoryRepository->remove($id, true);
        return new Response(null, 204);
    }
}
