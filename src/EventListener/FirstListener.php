<?php

    // src/EventListener/ExceptionListener.php
    namespace App\EventListener;

    use Psr\Log\LoggerInterface;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpKernel\Event\ControllerEvent;
    use Symfony\Component\HttpKernel\Event\ExceptionEvent;
    use Symfony\Component\HttpKernel\Event\RequestEvent;
    use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

    /**
     * Class FirstListener
     * Cette classe s'inscrit à des événements natifs à Symfony
     *
     * https://symfony.com/doc/current/reference/events.html#kernel-request
     *
     *
     * Attention,  il faut bien penser à enregistrer les événements dans services.yaml
     * # Event Listener
     *   App\EventListener\FirstListener:  # On donne le namespace de notre Listener
     *   tags:
     *   - { name: kernel.event_listener, event: kernel.request }
     *   - { name: kernel.event_listener, event: kernel.controller }
     *
     *
     * @package App\EventListener
     */
    class FirstListener
    {
        private $logger;

        public function __construct(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        // Sur l'événement kernel.request
        public function onKernelRequest(RequestEvent $event)
        {
            // ...

            $this->logger->info("Evenement Kernel Request");
            $this->logger->debug( "Type: " . $event->getRequestType() );
        }

        // Sur l'événement kernel.controller
        public function onKernelController(ControllerEvent $event)
        {
            // ...

            $this->logger->info("Evenement Kernel Controller");
            //$this->logger->debug($event );
        }
    }