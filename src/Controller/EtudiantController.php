<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiantold", name="etudiant")
     */
    public function index()
    {
        return $this->render('etudiant/index.html.twig', 
        [
            'controller_name' => 'EtudiantController',
            'nom'   => 'Moi'
        ]);
    }

    
    /**
     * @Route(
     *  "/etudiant/{nom?}/{prenom?}/",
     *  name="etudiant avec parametre",
     *  requirements=
     *      {
     *          "nom" = "\w+",
     *          "prenom" = "\w+"
     *      }
     * )
     */
    public function indexAvecParametre( $nom = "Dark", $prenom = "Vor" )
    {
        return $this->render('etudiant/index.html.twig', 
        [
            'controller_name' => 'EtudiantController avec le nom ET le prénom',
            'nom' => $nom,
            'prenom' => $prenom
        ]);
    }
}
