<?php

/**
 * Un controleur pour faire la démonstration de l'utilisation d'un service
 *
 * src/Service/Slugifier.php
 *
 *
 * Sources:
 * https://symfony.com/doc/current/controller/soap_web_service.html
 * https://symfony.com/doc/current/service_container.html#service-container-services-load-example
 *
 *
 * Pour afficher tous les services disponibles
 * php bin/console debug:container

 */

namespace App\Controller;

use App\Service\Slugifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index( Slugifier $slugifier )
    {
        $chaine = "Coucou";


        // Appel au service Slugifier
        $chaine = $slugifier->slugify( $chaine );

        dump ($chaine);
        die;

        // Attention au template à compléter
        return $this->render('service/index.html.twig', [
            'string' => $chaine
        ]);
    }
}
