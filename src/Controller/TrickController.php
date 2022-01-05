<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Services\Embedding;
use App\Repository\TrickRepository;
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
     * @Route("/trick", name="trick_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $this->repository->findAll(),
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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick créé avec success');

            return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("trick/{slug}-{id}", name="trick_show", methods={"GET", "POST"}, requirements = {"slug": "[a-z0-9\-]*"})
     */
    public function show(Trick $trick, string $slug, Request $request, EntityManagerInterface $entityManager): Response
    {
        if($trick->getSlug() !== $slug){
            return $this->redirectToRoute('trick_show', [
                'id'=> $trick->getId(),
                'slug' => $trick->getSlug()
            ], 301);
        }

        foreach ($trick->getVideos() as $video) {
        //dd ($video);//ok
        $url = $video->getUrl();
        //dd ($url);//ok
        $embedUrl = $this ->embedding->getEmbedPath($url);
         }

        // dd ($embedUrl);//ok

        $comment = new Comment();
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
            'embedUrl' => $embedUrl,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("trick/{id}/edit", name="trick_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
       // dd($request);
        foreach ($trick->getVideos() as $video) {
        //dd ($video);//ok
        $url = $video->getUrl();
        //dd ($url);//ok
        $embedUrl = $this ->embedding->getEmbedPath($url);
         }
        // dd ($embedUrl);//ok

        

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        foreach ($trick->getVideos() as $video) {
        $url = $video->getUrl();
        $embedUrl = $this ->embedding->getEmbedPath($url);
         }
        //dd ($embedUrl);//ok

            $entityManager->flush();
            $this->addFlash('success', 'Trick modifié avec success');

            # return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()], Response::HTTP_SEE_OTHER);
            # return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
             return $this->render('trick/index.html.twig', [
           'tricks' => $this->repository->findAll(),
            'embedUrl' => $embedUrl, 
        ]);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
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

        return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
    }
}
