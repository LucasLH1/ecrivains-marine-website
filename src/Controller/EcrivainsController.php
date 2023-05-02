<?php

namespace App\Controller;

use App\Entity\Ecrivains;
use App\Form\EcrivainsFormType;
use App\Form\ModifyEcrivainType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    public function detailEcrivain(ManagerRegistry $doctrine, int $id): Response {
        $ecrivain = $doctrine->getRepository(Ecrivains::class)->find($id);

        return $this->render('ecrivains/detailEcrivain.html.twig', [
            'controller_name'=>'EcrivainsController',
            'ecrivain'=>$ecrivain,
        ]);
    }

    public function manageEcrivainsList(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ecrivains = $doctrine->getRepository(Ecrivains::class)->findAll();

        return $this->render('ecrivains/manageEcrivainsList.html.twig', [
            'controller_name' => 'EcrivainsController',
            'ecrivains'=>$ecrivains
        ]);
    }
    public function addEcrivain(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ecrivains = $doctrine->getRepository(Ecrivains::class)->findAll();


        $form = $this->createForm(EcrivainsFormType::class);
        $form->handleRequest($request);
        $ecrivain = new Ecrivains();

        if ($form->isSubmitted() && $form->isValid()) {
            $ecrivain->setName($form->get('name')->getData());
            $ecrivain->setFirstname($form->get('firstname')->getData());
            $ecrivain->setDescription($form->get('description')->getData());
            $ecrivain->setAwards($form->get('awards')->getData());
            $ecrivain->setDisplayFirst($form->get('displayFirst')->getData());

            $profilePicture = $form->get('profilePicture')->getData();
            if ($profilePicture) {
                $originalFilename = pathinfo($profilePicture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profilePicture->guessExtension();

                try {
                    $profilePicture->move(
                        $this->getParameter('profilepictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $this->redirectToRoute('app_addecrivain');
                }
                $ecrivain->setProfilePicture($newFilename);
            }


            $entityManager->persist($ecrivain);
            $entityManager->flush();
        }

        return $this->render('ecrivains/addEcrivain.html.twig', [
            'controller_name' => 'EcrivainsController',
            'ecrivain_form'=>$form->createView(),
            'ecrivains'=>$ecrivains
        ]);
    }

    public function modifyEcrivain(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, SluggerInterface $slugger, int $id): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ecrivain = $doctrine->getRepository(Ecrivains::class)->find($id);

        $form = $this->createForm(ModifyEcrivainType::class);
        $form->get('name')->setData($ecrivain->getName());
        $form->get('firstname')->setData($ecrivain->getFirstname());
        $form->get('description')->setData($ecrivain->getDescription());
        $form->get('awards')->setData($ecrivain->getAwards());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ecrivain->setName($form->get('name')->getData());
            $ecrivain->setFirstname($form->get('firstname')->getData());
            $ecrivain->setDescription($form->get('description')->getData());
            $ecrivain->setAwards($form->get('awards')->getData());


            $entityManager->persist($ecrivain);
            $entityManager->flush();
        }

        return $this->render('ecrivains/modifyEcrivain.html.twig', [
            'controller_name' => 'EcrivainsController',
            'ecrivain_form'=>$form->createView(),
            'ecrivain'=>$ecrivain
        ]);
    }

    public function removeEcrivain(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ecrivain = $doctrine->getRepository(Ecrivains::class)->find($id);

        $entityManager->remove($ecrivain);
        $entityManager->flush();


        return $this->redirectToRoute('app_manageecrivainslist');
    }
}
