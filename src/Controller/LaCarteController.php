<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaCarteController extends AbstractController
{
    #[Route('/la-carte', name: 'app_la_carte')]
    public function index(): Response
    {
        return $this->render('la_carte/index.html.twig', [
            'controller_name' => 'LaCarteController',
        ]);
    }
}
