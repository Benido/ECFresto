<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminPreferencesController extends AbstractController
{
    #[Route('/administration/admin', name: 'app_administration_admin')]
    public function index(): Response
    {
        return $this->render('/administration/preferences_admin/index.html.twig', [

        ]);
    }

}
