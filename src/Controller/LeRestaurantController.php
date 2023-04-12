<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeRestaurantController extends AbstractController
{
    #[Route('/le-restaurant', name: 'app_le_restaurant')]
    public function index(): Response
    {
        return $this->render('le_restaurant/index.html.twig', [
            'controller_name' => 'LeRestaurantController',
        ]);
    }
}
