<?php

namespace App\Controller;

use App\Form\ClientPreferencesType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ClientPreferencesController extends AbstractController
{
    #[Route('/client-preferences', name: 'app_client_preferences')]
    public function index(Request $request, ClientRepository $clientRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $client = $this->getUser();

        $form = $this->createForm(ClientPreferencesType::class, $client);
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('newPassword')->getData();
            //On met à jour les champs mappés dans le formulaire
            $client = $form->getData();
            if ($form->get('newPasswordConfirmation')->getData()) {
                //On encode le nouveau mot de passe et on met à jour le champ correspondant
                $client->setPassword(
                    $userPasswordHasher->hashPassword(
                        $client,
                        $form->get('newPasswordConfirmation')->getData()
                    )
                );
            }
            $clientRepository->save($client, true);
            return $this->redirectToRoute('app_client_preferences');
        }

        return $this->render('client_preferences/index.html.twig', [
            'preferences' => $form,
            'reservations' => $client?->getReservations()
        ]);
    }
}
