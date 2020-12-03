<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('noms')
        ->add('prenoms')
        ->add('username')
        ->add('password', PasswordType::class)
        ->add('roles', ChoiceType::class, array(
            'choices' => array(
                'Utilisateur'=> 'ROLE_USER',
                'Editeur'=> 'ROLE_EDITOR',
                'Moderateur'=> 'ROLE_MODERA',
                'Administrateur'=> 'ROLE_ADMIN',
            ),
            'expanded'=>true,
            'multiple'=>true,
        ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
