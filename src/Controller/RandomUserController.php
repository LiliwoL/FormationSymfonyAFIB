<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RandomUserController extends AbstractController
{
    /**
     * @Route("/random/user", name="random_user")
     */
    public function index()
    {
        // Url
        $url = "https://randomuser.me/api/?results=50";

        // Appel de la fonction de récupération des données
        $datas = $this->makeRequest( $url );

        // On reçoit un tableau avec 2 sous tableaux!
        // On ne veut que le sous-tableau nommé results
        $datas = $datas['results'];

        return $this->render('random_user/index.html.twig', [
            'controller_name' => 'RandomUserController',
            'users' => $datas
        ]);
    }

    /**
     * Fonction qui exécutera la requete en cURL
     *
     * @param string $url
     * @return array
     */
    private function makeRequest ( string $url )
    {
        // Initialisation de cURL
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Au cas où on a un souci avec le SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);

        // Execute
        $result=curl_exec($ch);

        // En cas d'erreur
        if ( $result === false )
        {
            // Affichage de l'erreur
            dump ( curl_error($ch) );
        }

        // Closing
        curl_close($ch);

        // Decodage du JSON reçu
        $data = json_decode($result, true);

        // Renvoi du tableau JSON
        return (array) $data;
    }

}