<?php

namespace App\Form;

use App\Entity\Ecrivains;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSelectEcrivainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ecrivains', EntityType::class, [
                'class'=> Ecrivains::class,
                'placeholder'=>'Sélectionner un écrivain',
                'label'=>false,
                'attr' => [
                    'class' => 'form-select form-select-sm-5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Consulter',
                'attr' => [
                    'class' => 'w-100 btn-sm  btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
