<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Events;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Use spécifique à la gestion des droits d'accès via @Security
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

// Use spécifique pour la gestion des droits d'accès via @IsGranted
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_index", methods={"GET"})
     */
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

        /**
         * Route pour n'afficher que les films d'AVANT 2000
         * Utilisation de findMoviePastCentury() dans le Respository
         *
         * @Route("/old", name="movie_index_old", methods={"GET"})
         */
        public function indexOld(MovieRepository $movieRepository): Response
        {
            return $this->render('movie/index.html.twig', [
                'movies' => $movieRepository->findMoviePastCentury(),
            ]);
        }

        /**
         * Route pour illustrer l'utilisation de findby
         * Utilisation de findBy() dans le Respository
         *
         * @Route("/findby", name="movie_index_findby", methods={"GET"})
         */
        public function indexFindBy(MovieRepository $movieRepository): Response
        {
            return $this->render('movie/index.html.twig', [
                'movies' => $movieRepository->findBy(
                    //[ 'title' => 'AFIB' ]
                    [ 'duration' => 300 ]
                ),
            ]);
        }

    /**
     * @Route("/new", name="movie_new", methods={"GET","POST"})
     */
    public function new(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();


            // EVENT DISPATCHER
            // Ici je peux lancer (dispatcher) l'événement de création d'un film movie.created
            $event = new GenericEvent();
            //$eventDispatcher->dispatch( $event, 'movie.created'); // Sans l'utilisation de App/events.php
            $eventDispatcher->dispatch( $event, Events::MOVIE_CREATED); // Avec l'utilisation de App/Events.php (bonne pratique)



            return $this->redirectToRoute('movie_index');
        }

        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_show", methods={"GET"})
     */
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="movie_edit", methods={"GET","POST"})
     *
     *
     *
     * Restriction d'accès à cette route via Security
     * https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/annotations/security.html
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * Restriction d'accès via IsGranted
     * Attention au USE à spécifier plus haut
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Movie $movie): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movie_index');
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movie $movie, AuthorizationCheckerInterface $authChecker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token')))
        {
            // Fonctionnement sans vérification des droits (décommenter)
            /*
             * $entityManager = $this->getDoctrine()->getManager();
             * $entityManager->remove($movie);
             * $entityManager->flush();
             */

            // Vérification des droits
            if (false === $authChecker->isGranted('ROLE_ADMIN'))
            {
                // Ajouter le USE qui va avec!
                throw new AccessDeniedException('Unable to access this page!');
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($movie);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('movie_index');
    }
}
