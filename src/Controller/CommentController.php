<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/commentLM", name="commentLM", methods={"GET"})
     */
    public function commentLoadMore( CommentRepository $commentrepo, Request $request, EntityManagerInterface $entityManager): Response
    {

        // On définit le nombre d'éléments par page
        $limitlm = 2;   

        // On récupère le numéro de page
        $page = (int)$request->query->get("page",1);
        $id= (int)$request->query->get("id",1);
              
        // On récupère les comments de la page en fonction du filtre
  
        $comments=$commentrepo->getLoadMorecomments($page, $limitlm, $id);
       
        return $this->render('comment/ajax.html.twig', [
            'limitlm' => $limitlm, 
            'comments'=> $comments, 
        ]);

        
    }



}
