<?php

namespace App\Controller;

use App\Entity\Video;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/video")
 */

class VideoController extends AbstractController{

    /**
     * @Route("/{id}", name="video_delete", methods={"POST"})
     */
    public function delete(Request $request, Video $video): Response
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

        $trickId = $video->getTrick()->getId();

        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
            $this->addFlash('success', 'Video supprimé avec success');
        }
        return $this->redirectToRoute('trick_index', ['id' => $trickId]);

    }

}