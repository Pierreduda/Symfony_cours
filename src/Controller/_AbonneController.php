<?php

namespace App\Controller;

use App\Entity\Abonne;
use App\Form\AbonneType;
use App\Repository\AbonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("_", name="_")
 * @IsGranted("ROLE_ADMIN")
 */
class _AbonneController extends AbstractController
{
    /**
     * @Route("/abonne", name="abonne")
     */
    public function index(AbonneRepository $abonneRepository): Response
    {
        $liste_abonne = $abonneRepository->findAll();
        return $this->render('abonne/index.html.twig', compact("liste_abonne"));
    }
    /**
     * @Route("/abonne/add", name="abonne_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $abonne = new Abonne;
        // création d'un $formAbonne avec la méthode createForm qui va représenter le formulaire généré grâce à la classe AbonneType ce formulaire est lié à l'objet $Abonne
        $formAbonne = $this->createForm(AbonneType::class, $abonne);
        /* avec la méthode handleRequest, le $formAbonne va gérer les données qui viennent du formulaire On va aussi pouvoir savoir si le formulaire a été soumis et si il est valide */

        $formAbonne->handleRequest($request);

        if ($formAbonne->isSubmitted()) {
            if ($formAbonne->isValid()) {
                $em->persist($abonne);
                $em->flush();
                $this->addFlash("success", "Le nouvel abonné a bien été enregistré");
                return $this->redirectToRoute("abonne");
            } else {
                $this->addFlash("danger", "Le formulaire n'est pas valide");
            }
        }
        return $this->render("abonne/add.html.twig", ["formAbonne" => $formAbonne->createView()]);
    }
    /**
     * @Route("/abonne/update/{id}", name="abonne_update", requirements={"id"="\d+"})
     */
    public function update(AbonneRepository $abonneRepository, Request $request, EntityManagerInterface $em, $id)
    {

        $abonne = $abonneRepository->find($id);

        $formAbonne = $this->createForm(AbonneType::class, $abonne);
        $formAbonne->handleRequest($request);

        if ($formAbonne->isSubmitted() && $formAbonne->isValid()) {
            $em->flush();
            return $this->redirectToRoute("abonne");
        }
        return $this->render("abonne/add.html.twig", ["formAbonne" => $formAbonne->createView()]);
    }
    /**
     * @Route("/abonne/delete/{id}", name="abonne_delete", requirements={"id"="\d+"})
     */
    public function delete(AbonneRepository $abonneRepository, Request $request, EntityManagerInterface $em, $id)
    {
        $abonne = $abonneRepository->find($id);

        if ($request->isMethod("POST")) {
            $em->remove($abonne); 
            $em->flush();
            return $this->redirectToRoute("abonne");
        }

        return $this->render("abonne/delete.html.twig", compact("abonne"));
    }
}
