<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CnrsController extends AbstractController
{
    /**
     * @Route("/cnrs", name="cnrs")
     */
    public function index()
    {
        // Renvoi un bojet de type réponse
        return $this->render(
            'cnrs/index.html.twig', 
            [
                'controller_name' => 'CnrsController',
                'stagiaire' => 'Stéphane'
            ]
        );
    }

    /**
     * @Route("/coucou", name="coucou")
     */
    public function coucou()
    {
        // Renvoi d'une réponse
        return new Response(
            'Coucou'
        );
    }
}
