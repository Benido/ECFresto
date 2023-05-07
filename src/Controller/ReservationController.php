<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, RestaurantRepository $restaurantRepository, ReservationRepository $reservationRepository): Response
    {
        //On va chercher l'instance de la classe Restaurant utilisée pour pouvoir la passer au formulaire
        $restaurant = $restaurantRepository->findAll()[0];

        //On créé un nouvel objet réservation et on l'hydrate avec les données que l'on connaît déjà
        $reservation = new Reservation();
        $reservation->setRestaurant($restaurant);
        $client = ($this->getUser() && in_array('ROLE_CLIENT',$this->getUser()->getRoles())) ? $this->getUser() : null;
        if  ($this->getUser() && in_array('ROLE_CLIENT',$this->getUser()->getRoles())){
            $reservation->setClient($this->getUser());
        }

        //On prépare les options à passer au formulaire
        $day = $reservation->getDay();
        $seats = $reservation->getSeatsNumber();

        //Le cas échéant, on passe au formulaire les données de l'appel Ajax
        if ($request->request->has('day'))   $day = new \DateTime($request->request->get('day'));
        if ($request->request->has('seats')) $seats = $request->request->get('seats');

        $form = $this->createForm(ReservationType::class, $reservation, [
            'client' => $client,
            'day' => $day,
            'seats' => $seats
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
