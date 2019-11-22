<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    /**
     * @Route(
     *  "/mail",
     *  name="mail",
     *  methods={"GET"}
     * )
     */
    public function index()
    {
        // Construire notre formulaire à partir du MailType généré au préalabl
        // use App\Form\MailType;
        $formulaireMail = $this->createForm ( 
            MailType::class   // Classe du formulaire MailType
        );

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
            'formulaire'    => $formulaireMail->createView()
        ]);
    }

    /**
     * @Route(
     *  "/mail",
     *  name="mail envoyé",
     *  methods={"POST"}
     * )
     */
    public function gestionEmail( Request $request, \Swift_Mailer $mailer )
    {
        // J'ai reçu les paramètres en POST
        //dump($request);

        $formulaire = $this->createForm (
            MailType::class   // Classe du formulaire MailType
        );

        // Gestion de ce formulaire
        $formulaire->handleRequest($request);

        // Validation
        if ( $formulaire->isSubmitted() && $formulaire->isValid() )
        {
            // Récupération des données issues du formulaire dans une entité mail
            /* @var $mail Mail */
            $mail = $formulaire->getData();

            // Création de l'objet Message
            $message = new \Swift_Message(
                $mail->getObject(),
                "<h1>Mail en HTML</h1>"
            );

            // Affectation des expéditeurs et destinataires
            $message->addFrom( $mail->getSender() );
            $message->addTo( $mail->getDest() );

            $message->setContentType('text/html');

            // Le message est prêt à être envoyé
            // Envoi du message via le service SwiftMailer
            $result = $mailer->send($message);

            dump ($result);
        }


        return new Response("Mail envoyé");
    }
}
