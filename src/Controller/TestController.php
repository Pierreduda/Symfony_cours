<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    /**
     * @Route("/test/calcul/{b}/{a}", requirements={"b"="\d+", "a"="[0-9]+"})
     * 
     * usage d'une regex pour obliger à ce que les paramètres de la route soient uniquement composés de chiffres : 
     *  \d ou [0-9] veut dire un caractère numérique 
     *  + veut dire que le caractère précédent doit être présent au moins 1 fois
     *   
     */
    public function calcul($b, $a)
    {
        $resultat = $a + $b;
        // return $this->json([
        //     "calcul" => "$a + $b",
        //     "resultat" => $resultat
        // ]); 

        /*
            La méthode render construit l'affichage. le 1er paramètre est le nom de la vue à utiliser.
            Le nom de la vue est le chemin du fichier à partir du dossier "templates"
        */

        return $this->render("test/calcul.html.twig", [
            "result" => $resultat,
            "a" => $a,
            "b" => $b
        ]);

        /* EXO: affichez le resultat du calcul 5 + 6 est agal à 11 
        Modifiez la route pour que la valeur $b soit récupérée dans l'url
        */
    }

    /**
     * @Route("test/salut/{prenom}")
     * Une route paramétrée permet de récupérer une valeur dans l'URL. l'URL n'et pas fixe, la valeur du paramètre peut changer
     */
    public function salut($prenom)
    {
        // $prenom ="Jean";
        return $this->render("test/salut.html.twig", [
            "prenom" => $prenom
        ]);
    }

    /**
     * @Route("/test/tableau")
     * 
     */
    public function tableau()
    {
        $tab = ["nom" => "Cérien", "prenom" => "Jean"];
        return $this->render("test/tableau.html.twig", ["tableau" => $tab]);
    }

    /**
     * @Route("/test/objet")
     * 
     */

    public function objet()
    {
        $objet = new \stdClass;
        $objet->nom = "Mentor";
        $objet->prenom = "Gérard";
        return $this->render("test/tableau.html.twig", [
            "tableau" => $objet
        ]);
    }

    /**
     * @Route("/test/boucles")
     */
    public function boucles()
    {
        $tableau = ["bonjour", "je", "suis", "en", "cours", "de", "Symfony"];
        $chiffres = [];
        for ($i = 0; $i < 10; $i++) {
            $chiffres[] = $i * 12;
        }

        return $this->render("test/boucles.html.twig", [
            "chiffres" => $chiffres,
            "tableau" => $tableau
        ]);
    }
    /**
     * @Route("/test/condition")
     */
    public function condition()
    {
        $a = 12;
        $b = 5;
        $c = "";
        return $this->render("test/condition.html.twig", [
            "a" => $a,
            "b" => $b,
            "c" => $c
        ]);
    }
    /* EXO : 
    1. créer un controleur appelé Accueil qui va afficher "La bibliothèque est vide pour le moment"
    2. la route doit correspondre à la racine du site

    3. Dans le contrôleur Test, ajoutez 2 routes: 
        -Une route (/test/affiche-formulaire) qui affiche un formulaire html (POST)
        -L'autre (/test/affiche-donnees) qui affiche les données tapées dans ce formulaire (avec $_POST)
    */


    /**
     * @Route("/test/formulaire", name="test_formulaire")
     */
    public function formulaire()
    {
        return $this->render("test/formulaire.html.twig");
    }
    /**
     * @Route("/test/affichage", name="test_affichage")
     */
    public function affichage()
    {   
        if($_POST){
            extract($_POST);

            return $this->render("test/affichage.html.twig", compact("pseudo", "mdp") );
            /* compact() retourne un array associatif qui sera formé ainsi : 
                compact("pseudo", "mdp") --> ["pseudo" => $pseudo, "mdp" => $mdp]
                
                */

        }
        
    }

    /**
     * @Route("/test/test-donnees", name="test_donnees")
     * 
     * On ne peut pas instancier un objet de la classe Request, donc pour pouvoir l'utiliser, on va faire ce qu'on appelle l'injection de dépendance (vous verrez aussi parfois : autowiring) : en passant par les paramètres d'une méthode d'un controleur, l'objet de la classe est automatiquement instancié et remplit (si besoin)
     * Les classes que l'on peut utiliser avec l'injection de dépendances sont appelées des services (dans Symfony)
     * La classe Request contient toutes les valeurs des variables superglobales de PHP
     */
    public function testDonnees(Request $request){
        dump($request);
        dd($request); // dump and die : arrête l'execution du php apre le var-dump
        if($request->isMethod("POST")){
            $pseudo = $request->request->get("pseudo");
            // L'objet $request a une propriété 'request' qui contient $_POST
            // Cette propriété est un objet qui a une méthode get() pour récupérer une valeur
            // POur le contenu de $_GET, on utilisera, de la même façon, la propriété 'query
            $mdp = $request->request->get("mdp");
            return $this->render("test/donnees.html.twig", compact("pseudo", "mdp"));

        }
    }


}
