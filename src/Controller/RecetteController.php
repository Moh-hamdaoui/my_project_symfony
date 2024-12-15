<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class RecetteController extends AbstractController
{

    #[Route('/recettes', name: 'recette_index')]
    public function index(RecetteRepository $recetteRepository): Response
    {

        $recettes = $recetteRepository->findAll();

        return $this->render('page/index.html.twig', [
            'recettes' => $recettes, 
        ]);
    }

    #[Route("/recette/{id}", name: "recette_show")]
    public function show(int $id, RecetteRepository $recetteRepository): Response
    {

        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw $this->createNotFoundException('Recette non trouvée');
        }

        return $this->render('page/show.html.twig', [
            'recette' => $recette, 
        ]);
    }

    #[Route('/recette/{id}/comment', name: 'recette_comment')]
    public function comment(
        int $id,
        Request $request,
        RecetteRepository $recetteRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $recette = $recetteRepository->find($id);
    
        if (!$recette) {
            throw $this->createNotFoundException('Recette non trouvée');
        }
    
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setRecette($recette);
            $comment->setUser($this->getUser()); 
    
            $entityManager->persist($comment);
            $entityManager->flush();
    
            $this->addFlash('success', 'Votre commentaire a été ajouté !');
    
            return $this->redirectToRoute('recette_show', ['id' => $id]);
        }
    
        return $this->render('page/comment.html.twig', [
            'form' => $form->createView(),
            'recette' => $recette,
        ]);
    }
}
