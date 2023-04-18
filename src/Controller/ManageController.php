<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageController extends AbstractController
{
    public function manage(): Response
    {
        return $this->render('manage/index.html.twig', [
            'controller_name' => 'ManageController',
        ]);
    }
}
