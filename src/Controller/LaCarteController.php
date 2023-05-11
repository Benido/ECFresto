<?php

namespace App\Controller;

use App\Repository\DishCategoryRepository;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menus')]
class LaCarteController extends AbstractController
{
    #[Route('/', name: 'app_menus')]
    public function index(): Response
    {


        return $this->render('menus/index.html.twig', [

        ]);
    }

    #[Route('/la-carte', name: 'app_menus_la_carte')]
    public function laCarte(DishRepository $dishRepository, DishCategoryRepository $dishCategoryRepository): Response
    {
        $dishCategories = $dishCategoryRepository->findAll();
        $allDishes = $dishRepository->findAll();

        return $this->render('menus/la_carte/index.html.twig', [
            'categories' => $dishCategories,
            'dishes' => $allDishes,
        ]);
    }

    #[Route('/les-menus', name: 'app_menus_les_menus')]
    public function lesMenus(): Response
    {


        return $this->render('menus/la_carte/index.html.twig', [

        ]);
    }
}
