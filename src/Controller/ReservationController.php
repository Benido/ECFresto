<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Service\AvailableReservationDateGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, RestaurantRepository $restaurantRepository, ReservationRepository $reservationRepository, AvailableReservationDateGetter $dateGetter): Response
    {
        //On va chercher l'instance de la classe Restaurant utilisée pour pouvoir la passer au formulaire
        $restaurant = $restaurantRepository->findAll()[0];

        //On créé un nouvel objet réservation et le formulaire qui va l'alimenter
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation,
            [
                'restaurant' => $restaurant,
                'client' => ($this->getUser() !== null && in_array('ROLE_CLIENT',$this->getUser()->getRoles())) ?
                    $this->getUser()
                    : null,
            ]);

        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $reservationRepository->save($reservation, true);
            return $this->redirectToRoute('app_reservation');
        }

        return $this->render('reservation/index.html.twig', [
            'reservation' => $form,
        ]);
    }
}
