<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('homepage/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }
}
