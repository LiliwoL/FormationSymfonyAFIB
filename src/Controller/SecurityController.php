<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     *
     * @Route("/adduser", name="add_user")
     * @param EncoderFactoryInterface $encoder
     * @param EntityManager $entityManager
     */
    public function createUser( UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $user = new User();

        $plainPassword = 'test';
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setEmail( "test2@test.com" )
            ->setAvatar( "image.jpg" )
            ->setRoles( ["ROLE_USER"] )
            ->setPassword($encoded);

        $entityManager->persist( $user );
        $entityManager->flush();

        return new Response("User créé");
    }
}
