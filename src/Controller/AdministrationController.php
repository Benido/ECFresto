<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BusinessHoursRepository;

class AdministrationController extends AbstractController
{
    #[Route('/administration', name: 'app_administration')]
    public function index(BusinessHoursRepository $businessHoursRepository ): Response
    {
        //Formate un tableau représentant le planning hebdomadaire d'ouverture
        $formattedWeeklySchedule = $businessHoursRepository->getFormattedWeeklySchedule();

        return $this->render('administration/index.html.twig', [
            'formatted_weekly_schedule' => $formattedWeeklySchedule
        ]);
    }
}
