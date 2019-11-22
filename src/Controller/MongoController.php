<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;

class MongoController
{
    /**
     * @Route("/mongoTest", methods={"GET"})
     */
    public function mongoTest(DocumentManager $dm)
    {
        // https://symfony.com/doc/4.0/bundles/DoctrineMongoDBBundle/first_steps.html#add-mapping-information

        $user = new User();
        $user->setEmail("vincent@vfac.fr");
        $user->setFirstname("Vincent");
        $user->setLastname("Vincent");
        $user->setPassword(md5("VFACP@ssw0rd"));

        $dm->persist($user);
        $dm->flush();

        return new Response('Created user id '.$user->getId());
        //return new JsonResponse(array('Status' => 'OK'));
    }

    /**
     * @Route("/mongoTestList", methods={"GET"})
     */
    public function listAll ( DocumentManager $dm )
    {
        // https://symfony.com/doc/4.0/bundles/DoctrineMongoDBBundle/first_steps.html#add-mapping-information

        $liste = $dm->getRepository(User::class)->findAll();

        if (!$liste) {
            throw $this->createNotFoundException('No product found');
        }

        dump ($liste);
        die;

        return new Response ('Liste trouvée');
    }
}