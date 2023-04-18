<?php

namespace App\Form;

use App\Entity\Ecrivains;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class EcrivainsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label'=>'Prénom'
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description'
            ])
            ->add('awards', TextType::class, [
                'label'=>'Prix & concours'
            ])
            ->add('profilePicture', FileType::class, [
                'label'=>'Photo de profil',
                'mapped'=>false,
                'required'=>true,
//                'constraints' => [
//                    new File([
//                        'maxSize'=>'5000k',
//                        'mimeTypes' => [
//                            'application/png',
//                            'application/jpg',
//                        ],
//                        'mimeTypesMessage' => "Merci d'utiliser un format d'image valide"
//                    ])
//                ],
            ])

            ->add('Submit',SubmitType::class,[
                'label'=>'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ecrivains::class,
        ]);
    }
}
