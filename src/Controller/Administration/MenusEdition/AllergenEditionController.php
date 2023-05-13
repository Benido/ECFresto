<?php

namespace App\Controller\Administration\MenusEdition;

use App\Entity\Allergen;
use App\Form\AllergenType;
use App\Repository\AllergenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllergenEditionController extends AbstractController
{
    #[Route('/administration/publier-menus/editer-allergene-{id}', name: 'app_administration_editer-allergene', methods: 'POST')]
    public function editAllergen(Request $request, AllergenRepository $allergenRepository, int $id): Response
    {
        $allergen = $allergenRepository->find($id);
        $editAllergenForm = $this->createForm(AllergenType::class, $allergen, [
            'action' => $this->generateUrl('app_administration_editer-allergene', ['id' => $id])
        ]);
        $editAllergenForm->handleRequest($request);

        if ($editAllergenForm->isSubmitted() && $editAllergenForm->isValid()) {
            $allergen = $editAllergenForm->getData();
            $allergenRepository->save($allergen, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }

        return $this->render('/fragments/form/_allergen_form.html.twig',
            [
                'editAllergenForm' => $editAllergenForm,
            ]
        );
    }

    #[Route('/administration/publier-menus/supprimer-allergene/{id}', name: 'app_administration_supprimer-allergene', methods: 'POST')]
    public function removeAllergen(AllergenRepository $allergenRepository, Allergen $id): Response
    {
        $allergenRepository->remove($id, true);
        return new Response(null, 204);
    }
}