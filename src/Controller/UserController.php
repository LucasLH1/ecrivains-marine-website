<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAddType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function removeUser(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $doctrine->getRepository(User::class)->find($id);

        $entityManager->remove($user);
        $entityManager->flush();


        return $this->redirectToRoute('app_userlist');
    }

    public function addUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserAddType::class);
        $form->handleRequest($request);
        $user = new User();

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($form->get('email')->getData());
            $user->setPassword($form->get('password')->getData());
            $user->setName($form->get('name')->getData());
            $user->setFirstname($form->get('firstname')->getData());
            $user->setRoles(array('ROLE_ADMIN'));

            $plaintextPassword = $form->get('password')->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admininterface');

        }

        return $this->render('user/addUser.html.twig', [
            'addUserForm' => $form->createView()
        ]);

    }
}
