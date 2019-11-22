<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Methode 1 : via URL
            // Url
            $url = "https://my.api.mockaroo.com/json_users_with_avatar.json";
            // Appel de la fonction de récupération des données
            $datas = $this->makeRequest( $url );


            // Ensuite on interprète le jeu de données
            foreach ( $datas as $data )
            {
                // Nouvelle instance d'Actor
                $actor = new Actor();

                // Charger les données
                $actor->setFirstname( $data['firstname'] )
                    ->setLastname( $data['lastname'] )
                    ->setAge( $data['age'] )
                    ->setImage( $data['image'] )
                    ->setBiography( $data['biography'] );

                // Persistance en base
                $manager->persist( $actor );
            }

        // Méthode 2 : à la main
            // Nouvelle instance d'Actor
            $actor = new Actor();

            // Charger les données
            $actor->setFirstname( "Pascal" )
                ->setLastname( "CALVAT" )
                ->setAge( "50" )
                ->setImage( "https://robohash.org/nostrumnonaut.jpg?size=50x50&set=set1" )
                ->setBiography( "Formation Symfony" );

        // Persistance en base
        $manager->persist( $actor );


        $manager->flush();
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

        // On place le header demandé par Mockaroo
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-API-Key: ec91eef0'
        ));

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
