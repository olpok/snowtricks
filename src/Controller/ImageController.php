<?php

namespace App\Controller;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/image")
 */

class ImageController extends AbstractController{

    /**
     * @Route("/{id}", name="image_delete", methods={"POST"})
     */
    public function delete(Request $request, Image $image): Response
    {
        /* après AJAX
         $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
            return new JsonResponse(['success' => 1]);
        }
        
        return new JsonResponse(['error' => 'Token invalide', 400]);*/

        $trickId = $image->getTrick()->getId();

        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
            $this->addFlash('success', 'Image supprimé avec success');
        }
        return $this->redirectToRoute('trick_edit', ['id' => $trickId]);

    }

}