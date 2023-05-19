<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusNavItemsController extends AbstractController
{
    #[Route('/menus-items', name: 'app_menus_items')]
    public function getMenus (MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();

        return $this->render('fragments/layout/_menus_nav_items.html.twig', [
            'menus' => $menus
        ]);
    }
}