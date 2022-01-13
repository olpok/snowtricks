<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Services\Embedding;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TrickController extends AbstractController
{   
    /**
    * @var TrickRepository
    */
    private $repository; 
    protected $embedding;

    public function __construct(TrickRepository $repository, Embedding $embedding)
    {
        $this->repository=$repository;
        $this->embedding = $embedding;
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'tricks' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        // On définit le nombre d'éléments par page
        $limit = 5;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les annonces de la page en fonction du filtre
       
       $tricks= $this->repository->getPaginatedTricks($page, $limit); 
        
       // On récupère le nombre total de tricks
        $total = $this->repository->getTotalTricks();        
        
        return $this->render('trick/list.html.twig', [
           // 'tricks' => $this->repository->findAll(), 
           'tricks'=> $tricks, 
           'total' => $total, 
           'limit'=> $limit,
           'page' => $page

           // compact('tricks', 'limit', 'page', )
        ]);
    }


    /**
     * @Route("/trick", name="trick_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

      /*  $em = $this->getDoctrine()->getManager();
        $result = $em->createQuery('select m from CoreBundle:Categories m')
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);*/
        
        $repository = $entityManager->getRepository(Trick::class);
        $tricks = $repository->findAll();
       // dd($tricks);//ok

       
         foreach($tricks as $trick){
         //   dd($trick);//ok

          //  dd($trick->getVideos());//ok Oblect and not an array
            $embedUrl= array();
            foreach ($trick->getVideos() as $video) {          
                  $url = $video->getUrl();
                   // dd ($url);//ok
                 array_push($embedUrl, $this ->embedding->getEmbedPath($url)) ; 
            }

           // dd ($embedUrl);//ok for 1 trick
 
         } 
           

         //  dd ($embedUrl);// only the last

/*
        $embedUrl= array();
        foreach ($trick->getVideos() as $video) {   
        //dd ($video);//ok
        $url = $video->getUrl();
        //dd ($url);//ok
        array_push($embedUrl, $this ->embedding->getEmbedPath($url)) ; 
         }*/ 

        return $this->render('trick/index.html.twig', [
            'tricks' => $this->repository->findAll(),
            'embedUrl' => $embedUrl

        ]);
    }

    /**
     * @Route("/trick/new", name="trick_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        $user = $this->getUser();//fetching the User Object of the current User after authentication 

        if ($form->isSubmitted() && $form->isValid()) {
            $trick  ->setUser($user);
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick créé avec success');

            return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("trick/{slug}-{id}", name="trick_show", methods={"GET", "POST"}, requirements = {"slug": "[a-z0-9\-]*"})
     */
    public function show(Trick $trick, CommentRepository $commentrepo, string $slug, Request $request, EntityManagerInterface $entityManager): Response
    {
        if($trick->getSlug() !== $slug){
            return $this->redirectToRoute('trick_show', [
                'id'=> $trick->getId(),
                'slug' => $trick->getSlug()
            ], 301);
        }
        
        $embedUrl= array();
        foreach ($trick->getVideos() as $video) {   
        //dd ($video);//ok
        $url = $video->getUrl();
        //dd ($url);//ok
        array_push($embedUrl, $this ->embedding->getEmbedPath($url)) ; 
         }

        // dd ($embedUrl);//ok

        // Comments pagination
        
        // On définit le nombre d'éléments par page
            $limit = 10;

        // On récupère le numéro de page
           $page = (int)$request->query->get("page",1);
        
        // On récupère les comments de la page en fonction du filtre
        $comments= $commentrepo->getPaginatedComments($page, $limit); 
         // dd($comments);//ok 10 comments

        // On récupère le nombre total de comments
        $total = $commentrepo->getTotalComments();
        // dd($total);//ok 13

        $comment = new Comment();
        $comment->setTrick($trick);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();//fetching the User Object of the current User after authentication 
            $comment->setTrick($trick)
                     ->setUser($user);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('trick_show', [
                'id' => $trick->getId(),
                'embedUrl' => $embedUrl,
                'slug' => $trick->getSlug()
            ]);

        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'comments'=> $comments, 
            'total' => $total, 
            'limit'=> $limit,
            'page' => $page,
            'embedUrl' => $embedUrl,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("trick/{id}/edit", name="trick_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $embedUrl= array();
        foreach ($trick->getVideos() as $video) {
        //dd ($video);//ok
        $id=$video->getId();
       // dd($id);//ok
        $url = $video->getUrl();
        //dd ($url);//ok
       // $embedUrl = $this ->embedding->getEmbedPath($url); //ok for 1 element
        array_push($embedUrl, $this ->embedding->getEmbedPath($url)) ;
          //dd($id);//ok
         }
         // dd($id);//ok
        // dd ($embedUrl);//ok


        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        foreach ($trick->getVideos() as $video) {
        $url = $video->getUrl();
         $id=$video->getId();
        // dd($id);
        $embedUrl = $this ->embedding->getEmbedPath($url);
         }
        //dd ($embedUrl);//ok
       // dd($id);

            $entityManager->flush();
            $this->addFlash('success', 'Trick modifié avec success');

            # return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()], Response::HTTP_SEE_OTHER);
             return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'videoid'=> $id,
            'embedUrl' => $embedUrl, 
            'form' => $form,
        ]);
    }

    /**
     * @Route("trick/{id}", name="trick_delete", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick supprimé avec success');
        }

        return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
       // return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
