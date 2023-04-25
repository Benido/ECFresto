<?php

namespace App\Controller;


use App\Form\BusinessHoursUpdateType;
use App\Repository\BusinessHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessHoursUpdateController extends AbstractController
{
    #[Route('/administration/business-hours-update', name: 'app_business_hours_update')]
    public function update(Request $request, BusinessHoursRepository $businessHoursRepository): Response
    {
        $form = $this->createForm(BusinessHoursUpdateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Diminue d'un rang l'arborescence du tableau
            $businessHoursCollection = array_merge(...array_values($form->getData()));
            //echo '<pre>' , var_dump($form['BusinessHoursFormType'][0]['isClosed']->getData()) , '</pre>';
            $businessHoursRepository->removeAndSaveNew($businessHoursCollection);

            return $this->redirectToRoute("app_business_hours_update");
        }

        return $this->render('business_hours_update/index.html.twig', [
           'BusinessHoursUpdate'  => $form,
        ]);
    }
}
