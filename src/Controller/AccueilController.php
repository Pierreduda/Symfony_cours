<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(LivreRepository $livreRepository): Response
    {
        $liste_livre = $livreRepository->findAll();
        $livres_indisponibles = $livreRepository->livresIndisponibles();
        if(empty($liste_livre)){
            $this->addFlash("info", "La bibliothèque est vide pour le moment");
        }
        return $this->render('accueil/index.html.twig', compact("liste_livre", "livres_indisponibles"));
    }
}
