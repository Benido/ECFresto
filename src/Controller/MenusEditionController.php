<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Menu;
use App\Form\DishCategoryType;
use App\Form\DishType;
use App\Form\FormulaType;
use App\Form\MenuType;
use App\Repository\DishCategoryRepository;
use App\Repository\DishRepository;
use App\Repository\FormulaRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusEditionController extends AbstractController
{
    #[Route('/administration/publier-menus', name: 'app_administration_publier_menus')]
    public function index(Request $request, DishRepository $dishRepository, MenuRepository $menuRepository, DishCategoryRepository $dishCategoryRepository): Response
    {
        $allCategories = $dishCategoryRepository->findAll();
        $allDishes = $dishRepository->findAll();
        $allMenus = $menuRepository->findAll();

        return $this->render('/administration/publier_menus/index.html.twig', [
            'allDishes' => $allDishes,
            'allMenus' => $allMenus,
            'allCategories' => $allCategories,
        ]);
    }

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

    #[Route('/administration/publier-menus/editer-menu/{id}', name: 'app_administration_editer-menu', methods: 'POST')]
    public function editMenu(Request $request, MenuRepository $menuRepository, ?int $id = null): Response
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

    #[Route('/administration/publier-menus/editer-categorie-{id}', name: 'app_administration_editer-categorie', methods: 'POST')]
    public function editCategory(Request $request, DishCategoryRepository $categoryRepository, int $id): Response
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

    #[Route('/administration/publier-menus/editer-formule/{menu}/{id}', name: 'app_administration_editer-formule', methods: 'POST')]
    public function editFormula(Request $request, FormulaRepository $formulaRepository, Menu $menu, int $id): Response
    {
        $formula = $formulaRepository->find($id);
        $editFormulaForm = $this->createForm(FormulaType::class, $formula, [
            'action' => $this->generateUrl('app_administration_editer-formule',
                [
                    'menu' => $menu->getId(),
                    'id' => $id
                ])
        ]);
        $editFormulaForm->handleRequest($request);

        if ($editFormulaForm->isSubmitted() && $editFormulaForm->isValid()) {
            $formula = $editFormulaForm->getData();
            $formula->setMenu($menu);
            $formulaRepository->save($formula, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }

        return $this->render('/fragments/form/_formula_form.html.twig',
            [
                'editFormulaForm' => $editFormulaForm,
            ]
        );
    }





}