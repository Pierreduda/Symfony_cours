<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface; // Doctrine c'est tout ce qui gère la bdd dans symfony
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// /!\ Mettre la route admin au dessus de la classe modifie la route de tout le controller
// dans security.yaml on va déterminer quel ROLE a accès à toute la partie /admin

/**
 * @Route("/biblio")
 * @IsGranted("ROLE_BIBLIOTHECAIRE")
 * Toutes les routes de ce controller vont commencer par /admin et elles sont toutes accessibles uniquement par un ROLE_ADMIN
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/livre", name="livre")
     */
    public function index(LivreRepository $livreRepository): Response
    {
        $liste_livre = $livreRepository->findAll();
        $livres_indisponibles = $livreRepository->livresIndisponibles();
        return $this->render('livre/index.html.twig', compact("liste_livre", "livres_indisponibles")
    );
    }
    /**
     * @Route("/livre/add", name="livre_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $livre = new Livre;
        // création d'un $formLivre avec la méthode createForm qui va représenter le formulaire généré grâce à la classe LivreType ce formulaire est lié à l'objet $livre
        $formLivre = $this->createForm(LivreType::class, $livre);
        /* avec la méthode handleRequest, le $formLivre va gérer les données qui viennent du formulaire On va aussi pouvoir savoir si le formulaire a été soumis et si il est valide */

        $formLivre->handleRequest($request);
        // récupère ce qu'il y a dans la requete http, dans les superglobales 
        if ($formLivre->isSubmitted()) {
            if ($formLivre->isValid()) {
                $em->persist($livre); // la méthode persist() prépare la requête INSERT INTO à partir de l'objet, c'est l'équivalent de "prepare"
                $em->flush(); // flush execute les requetes en attente
                $this->addFlash("success", "Le nouveau livre a bien été enregistré");
                return $this->redirectToRoute("livre"); // le paramètre doit être un name de route et non un URL
            } else {
                $this->addFlash("danger", "Le formulaire n'est pas valide");
            }
        }
        return $this->render("livre/add.html.twig", ["formLivre" => $formLivre->createView()]);
    }
    /**
     * @Route("livre/update/{id}", name="livre_update", requirements={"id"="\d+"})
     */
    public function update(LivreRepository $livreRepository, Request $request, EntityManagerInterface $em, $id)
    {

        $livre = $livreRepository->find($id);

        // on reprend la même technique pour le add
        $formLivre = $this->createForm(LivreType::class, $livre);
        $formLivre->handleRequest($request);
        if ($formLivre->isSubmitted() && $formLivre->isValid()) {
            // Dès qu'un objet entity a un id non null, l'EntityManager va mettre la bdd à jour avec les informations de cet objet directement avec la méthode flush
            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/add.html.twig", ["formLivre" => $formLivre->createView()]);
    }

    /**
     * @Route("/livre/delete/{id}", name="livre_delete", requirements={"id"="\d+"})
     */
    public function delete(LivreRepository $livreRepository, Request $request, EntityManagerInterface $em, $id)
    {
        $livre = $livreRepository->find($id);

        if ($request->isMethod("POST")) {
            $em->remove($livre); // La méthode remove() prépare une requête DELETE
            $em->flush();
            return $this->redirectToRoute("livre");
        }

        return $this->render("livre/delete.html.twig", compact("livre"));
    }
    /**
     * @Route("/livre/detail/{id}", name="livre_detail", requirements={"id"="\d+"})
     */
    public function detail(LivreRepository $livreRepository, $id)
    {
        $livre = $livreRepository->find($id);
        return $this->render("livre/detail.html.twig", compact("livre"));
    }
    /**
     * @Route("/test/find", name="test_find")
     */
    public function testfind(LivreRepository $lr)
    {
        $livres = $lr->findBy(["titre" => "La Reine Margot"]);
        dd($livres);
    }
}
