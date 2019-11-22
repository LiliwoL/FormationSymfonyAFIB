<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * Une route en GET pour afficher le formulaire de création
     *
     * @Route(
     *     "/article/new",
     *     name="article",
     *     methods = {"GET"}
     * )
     */
    public function new()
    {
        // Création du formulaire Article
        $formulaireArticle = $this->createForm (
            ArticleType::class // Classe qui définit le formulaire
        );

        // Réponse avec une vue et son formulaire
        return $this->render('article/index.html.twig', [
            'formulaireArticle' => $formulaireArticle->createView()
        ]);
    }

    /**
     * Une route en POST pour ajouter l'article en base
     *
     * @Route(
     *     "/article/new",
     *     name="article en POST",
     *     methods = {"POST"}
     * )
     */
    public function newPost( Request $request, EntityManagerInterface $em )
    {
        // Création du formulaire Article
        $formulaireArticle = $this->createForm (
            ArticleType::class // Classe qui définit le formulaire
        );

        // Gestion de la requête
        $formulaireArticle->handleRequest( $request );


        // Récupération des données issues du formulaire
        $article = $formulaireArticle->getData();

        // Récupérer l'entity manager
        $em->persist( $article );

        // On applique vraiment les changements
        $em->flush();


        // Réponse avec une vue et son formulaire
        return $this->render('article/index.html.twig', [
            'formulaireArticle' => $formulaireArticle->createView()
        ]);
    }

    /**
     * Une route pour afficher TOUS les articles
     *
     * @Route(
     *     "/articles",
     *     name="Liste des articles"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list ()
    {
        // Récupération de TOUS les articles avec le REPOSITORY
            // 1. Récupération du repository Article
            $articleRepository = $this->getDoctrine()
                                    ->getRepository(Article::class);

            // 2. Appel à la fonction findAll
            $liste = $articleRepository->findAll();

        // Renvoi de la liste à la vue
        return $this->render('article/list.html.twig', [
            'listeArticles' => $liste
        ]);
    }

    /**
     * Une route pour n'en afficher qu'un SEUL
     *
     * @Route(
     *     "/article/{id}",
     *     name="Afficher un article"
     * )
     */
    public function read( $id )
    {
        // Récupération de l'article en question avec le REPOSITORY
        // 1. Récupération du repository Article
        $articleRepository = $this->getDoctrine()
            ->getRepository(Article::class);

        // 2. Appel à la fonction find
        $article = $articleRepository->find( $id );

        // Tester le retour
        if ( !$article )
        {
            throw $this->createNotFoundException(
                'Aucun article trouvé ' . $id
            );
        }

        // Création du formulaire Article à partir de l'instance article récupérée plus haut
        $formulaireArticle = $this->createForm (
            ArticleType::class, // Classe qui définit le formulaire
            $article
        );

        // Renvoi de l'article à la vue
        return $this->render('article/article.html.twig', [
            'article' => $article,
            // On renvoie aussi la vue du formulaire pré-rempli
            'formulaireArticle' => $formulaireArticle->createView()
        ]);
    }

    /**
     * Une route pour mettre à jour un article
     *
     * @Route(
     *     "/article/{id}",
     *     name="Mettre à jour un article",
     *     methods = {"POST"}
     * )
     */
    public function update ( Request $request )
    {
        // Mise à jour d'une entit" article
    }
}
