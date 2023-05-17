<?php

namespace App\Controller\Administration;


use App\Form\BusinessHoursUpdateType;
use App\Repository\BusinessHoursRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessHoursUpdateController extends AbstractController
{
    #[Route('/administration/business-hours-update', name: 'app_administration_business_hours_update')]
    public function update(Request $request, BusinessHoursRepository $businessHoursRepository, RestaurantRepository $restaurantRepository): Response
    {

        $restaurant = $restaurantRepository->findAll()[0];
        $form = $this->createForm(BusinessHoursUpdateType::class, null, ['restaurant' => $restaurant]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Diminue d'un rang l'arborescence du tableau
            $businessHoursCollection = array_merge(...array_values($form->getData()));
            $businessHoursRepository->removeAndSaveNew($businessHoursCollection);

            return $this->redirectToRoute("app_administration_business_hours_update");
        }

        return $this->render('/administration/editer_horaires/index.html.twig', [
           'BusinessHoursUpdate'  => $form,
        ]);
    }
}
