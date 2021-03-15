<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $rq, LivreRepository $lr): Response
    {

        /*
        Un objet de la classe Request a des propriétés qui contiennent les valeurs des superglobales 
        $rq->query : $_GET
        $rq->request : $_POST 
        $r->cookies : $_COOKIE... 
        */
        $search = $rq->query->get("search");
        $liste_livre = $lr->recherche($search);
        return $this->render('search/index.html.twig', compact("liste_livre", "search"));
    }
    public function search(){

    }
}
