<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminSelectEcrivainType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ManageController extends AbstractController
{
    public function manage(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(AdminSelectEcrivainType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $ecrivain = $form->get('ecrivains')->getData();

            return $this->redirectToRoute('app_modifyecrivain',array('id' => $ecrivain->getId()));

        }

            return $this->render('manage/index.html.twig', [
            'controller_name' => 'ManageController',
            'selectForm' => $form->createView()
        ]);
    }

    public function userList(ManagerRegistry $doctrine): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render('manage/userList.html.twig', [
            'controller_name'=>'ManageController',
            'users' => $users,
        ]);

    }

}
