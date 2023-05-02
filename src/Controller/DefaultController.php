<?php

namespace App\Controller;

use App\Entity\Ecrivains;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index( ): Response
    {

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function association( ): Response
    {
        return $this->render('default/association.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }

    public function testPage(ManagerRegistry $doctrine): Response
    {

        $ecrivains = $doctrine->getRepository(Ecrivains::class)->findAll();


        return $this->render('default/testPage.html.twig', [
            'controller_name' => 'DefaultController',
            'ecrivains'=>$ecrivains
        ]);
    }
}