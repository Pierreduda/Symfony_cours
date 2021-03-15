<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profil")
 *
 */

class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil")
     *
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }
    /**
     * @Route("/profil/newEmprunt{id}", name="profil_new_emprunt")
     *
     */
    public function newEmprunt(LivreRepository $livreRepository, $id): Response
    {
        $user = $this->getUser();
        $livre = $livreRepository->find($id);
        $date = new \DateTime();

        $emprunt = new Emprunt();
        $emprunt->setDateEmprunt($date);
        $emprunt->setLivre($livre);
        $emprunt->setAbonne($user);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($emprunt);
        $entityManager->flush();
        $this->addFlash("success", "Emprunt confirmé");
        return $this->redirectToRoute('profil');
    }
}
