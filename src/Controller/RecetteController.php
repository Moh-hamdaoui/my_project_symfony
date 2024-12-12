<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{

    #[Route('/recettes', name: 'recette_index')]
    public function index(RecetteRepository $recetteRepository): Response
    {
        // Récupérer toutes les recettes depuis la base de données
        $recettes = $recetteRepository->findAll();

        return $this->render('page/index.html.twig', [
            'recettes' => $recettes, 
        ]);
    }

    #[Route("/recette/{id}", name: "recette_show")]
    public function show(int $id, RecetteRepository $recetteRepository): Response
    {
        // Récupérer une recette spécifique depuis la base de données
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw $this->createNotFoundException('Recette non trouvée');
        }

        return $this->render('page/show.html.twig', [
            'recette' => $recette, 
        ]);
    }
}
