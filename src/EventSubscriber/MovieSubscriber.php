<?php

namespace App\EventSubscriber;

use App\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Class MovieSubscriber
 * On va définir ici le comportement pour tous les événements auxquels on aura "souscrit"
 * https://symfony.com/doc/current/event_dispatcher.html#creating-an-event-subscriber
 * @package App\EventSubscriber
 */
class MovieSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Méthode lancée à l'événement Events::MOVIE_CREATED ou movie.created
     * @param $event
     */
    public function onMovieCreated( $event )
    {
        // Debug
        //dump ($event);
        //die;
        $this->logger->info( "Movie created" );
    }

    public static function getSubscribedEvents()
    {
        return [
            // Méthode sans passer par la déclaration générale des noms des événements dans App/Events.php
            //'movie.created' => 'onMovieCreated',

            // Méthode (bonne pratique) via App/Events.php
            Events::MOVIE_CREATED => 'onMovieCreated',
        ];
    }
}
