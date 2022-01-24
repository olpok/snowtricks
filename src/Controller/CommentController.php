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
     * @Route("/comment", name="comment")
     *//*
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',

        ]);
    }*/

    /**
     * @Route("/commentLM", name="commentLM", methods={"GET"})
     */
    public function commentLoadMore( CommentRepository $commentrepo, Request $request, EntityManagerInterface $entityManager): Response
    {

        // On définit le nombre d'éléments par page
        $limitlm = 2;   
      //  $comments= $commentrepo->findAll();

        // On récupère le numéro de page
        $page = (int)$request->query->get("page",1);
        $id= (int)$request->query->get("id",1);

     //   dd($id);//ok
              
        // On récupère les comments de la page en fonction du filtre
  
      $comments=$commentrepo->getLoadMorecomments($page, $limitlm, $id);
     
        
      //   dd($lmcomments);//ok 4 comments
         
     //    $comments= $commentrepo->getLoadMorecomments($page, $limit, $trick->getId());  

        // On récupère le nombre total de comments
       // $total = $commentrepo->getTotalComments();
    //    $total= $trick->getComments()->count();
        
        
        
        return $this->render('comment/ajax.html.twig', [
            'limitlm' => $limitlm, 
            'comments'=> $comments, 
          /*  'total' => $total, 
           'limit'=> $limit,
           'page' => $page*/
        ]);

        
    }



}
