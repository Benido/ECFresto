<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientPreferencesController extends AbstractController
{
    #[Route('/client-preferences', name: 'app_client_preferences')]
    public function index(): Response
    {
        return $this->render('client_preferences/index.html.twig', [
            'controller_name' => 'ClientPreferencesController',
        ]);
    }
}
