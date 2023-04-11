<?php

namespace App\Controller;

use App\Entity\Ecrivains;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcrivainsController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $ecrivains = $doctrine->getRepository(Ecrivains::class)->findAll();

        return $this->render('ecrivains/index.html.twig', [
            'controller_name' => 'EcrivainsController',
            'ecrivains'=>$ecrivains
        ]);
    }
}
