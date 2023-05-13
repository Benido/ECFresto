<?php

namespace App\Controller\Administration\MenusEdition;


use App\Repository\AllergenRepository;
use App\Repository\DishCategoryRepository;
use App\Repository\DishRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusEditionDashboardController extends AbstractController
{
    #[Route('/administration/publier-menus', name: 'app_administration_publier_menus')]
    public function index(DishRepository $dishRepository,
                          MenuRepository $menuRepository,
                          DishCategoryRepository $dishCategoryRepository,
                          AllergenRepository $allergenRepository
    ): Response
    {
        $allCategories = $dishCategoryRepository->findAll();
        $allDishes = $dishRepository->findAll();
        $allMenus = $menuRepository->findAll();
        $allAllergens = $allergenRepository->findAll();

        return $this->render('/administration/publier_menus/index.html.twig', [
            'allDishes' => $allDishes,
            'allMenus' => $allMenus,
            'allCategories' => $allCategories,
            'allAllergens' => $allAllergens
        ]);
    }
}