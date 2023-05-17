<?php

namespace App\Controller\Administration;

use App\Form\AdminPreferencesType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminPreferencesController extends AbstractController
{
    #[Route('/administration/admin', name: 'app_administration_admin')]
    public function indexRequest (Request $request, AdminRepository $adminRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
            $admin = $this->getUser();

            $form = $this->createForm(AdminPreferencesType::class, $admin);
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('newPassword')->getData();
            //On met à jour les champs mappés dans le formulaire
                $admin = $form->getData();
            if ($form->get('newPasswordConfirmation')->getData()) {
                //On encode le nouveau mot de passe et on met à jour le champ correspondant
                    $admin->setPassword(
                    $userPasswordHasher->hashPassword(
                            $admin,
                        $form->get('newPasswordConfirmation')->getData()
                    )
                );
            }
                    $adminRepository->save($admin, true);
            return $this->redirectToRoute('app_administration_admin');
        }

        return $this->render('/administration/preferences_admin/index.html.twig', [
            'preferences' => $form,
        ]);
    }

}
