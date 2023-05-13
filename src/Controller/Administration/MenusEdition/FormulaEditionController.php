<?php

namespace App\Controller\Administration\MenusEdition;

use App\Entity\Formula;
use App\Entity\Menu;
use App\Form\FormulaType;
use App\Repository\FormulaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaEditionController extends AbstractController
{
    #[Route('/administration/publier-menus/editer-formule/{menu}/{id}', name: 'app_administration_editer-formule', methods: 'POST')]
    public function editFormula(Request $request, FormulaRepository $formulaRepository, Menu $menu, ?int $id): Response
    {
        $formula = $formulaRepository->find($id);
        $editFormulaForm = $this->createForm(FormulaType::class, $formula, [
            'action' => $this->generateUrl('app_administration_editer-formule',
                [
                    'menu' => $menu->getId(),
                    'id' => $id
                ])
        ]);
        $editFormulaForm->handleRequest($request);

        if ($editFormulaForm->isSubmitted() && $editFormulaForm->isValid()) {
            $formula = $editFormulaForm->getData();
            $formula->setMenu($menu);
            $formulaRepository->save($formula, true);
            return $this->redirectToRoute('app_administration_publier_menus');
        }
        return $this->render('/fragments/form/_formula_form.html.twig',
            [
                'editFormulaForm' => $editFormulaForm,
                'menuId' => $menu->getId()
            ]
        );
    }

    #[Route('/administration/publier-menus/supprimer-formule/{id}', name: 'app_administration_supprimer-formule', methods: 'POST')]
    public function removeFormula(FormulaRepository $formulaRepository, Formula $id): Response
    {
        $formulaRepository->remove($id, true);
        return new Response(null, 204);
    }
}
