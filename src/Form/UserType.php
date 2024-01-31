<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            //  on les considere comme des champs mappé relier a une entity
            // si on ajoute age comme ca "->add('age', NumberType::class, [ 'mapped' => false"
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

            'data_class' => User::class,
        ]);
    }
}
