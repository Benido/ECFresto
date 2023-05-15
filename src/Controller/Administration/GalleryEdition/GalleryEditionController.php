<?php

namespace App\Controller\Administration\GalleryEdition;

use App\Entity\Image;
use App\Form\ImageFormType;
use App\Repository\ImageRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class GalleryEditionController extends AbstractController
{
    #[Route('/administration/modifier-galerie', name: 'app_administration_modifier_galerie')]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('administration/modifier_galerie/index.html.twig', [
            'allImages' => $imageRepository->findAll()
        ]);
    }

    #[Route('/administration/modifier-galerie/editer/{id}', name: 'app_administration_modifier_galerie_editer')]
    public function edit(Request $request, int $id, ImageRepository $imageRepository, CacheManager $cacheManager, UploaderHelper $helper): Response
    {
        $image = $imageRepository->find($id);
        $form = $this->createForm(ImageFormType::class, $image, [
            'action' => $this->generateUrl('app_administration_modifier_galerie_editer', ['id'=> $id])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData();
            //Si une nouvelle image a été téléchargée, on supprime l'ancien thumbnail du cache
            if ($image->getImageFile() instanceof UploadedFile) {
                //cacheManager gère le cache de LiipImagine et helper est une classe de VichUploader
                $cacheManager->remove($helper->asset($image, 'imageFile'));
            }
           ;
            $imageRepository->save($image, true);

            return $this->redirectToRoute('app_administration_modifier_galerie');
        }
        return $this->render('fragments/form/_image_form.html.twig', [
            'imageForm' => $form
        ]);
    }


    #[Route('/administration/modifier-galerie/supprimer/{image}', name: 'app_administration_modifier_galerie_supprimer')]
    public function delete(Image $image, ImageRepository $imageRepository, CacheManager $cacheManager, UploaderHelper $helper): Response
    {
        $cacheManager->remove($helper->asset($image, 'imageFile'));
        $imageRepository->remove($image, true);
        return new Response(null, 204);
    }
}