<?php

namespace App\Form;

use App\Entity\Ecrivains;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyEcrivainType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name',TextType::class, [
                'required' => false,

            ])
            ->add('firstname', TextType::class, [
                'required' => false,
                'label'=>'Prénom',

            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description',
                'required' => false,
                'attr' => [
                    'class' => 'tinymce',
                ],
                'empty_data' => 'John Doe',
            ])
            ->add('awards', TextType::class, [
                'required' => false,
                'label'=>'Prix & concours',
                'empty_data' => 'John Doe',

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
            'ecrivain' => Ecrivains::class
        ]);

    }
}
