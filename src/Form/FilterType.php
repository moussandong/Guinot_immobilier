<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Model\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keywword')
            ->add("categorie", EntityType::class, [
            "class" => Categorie::class,
            "choice_label" => "titre"
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data-class" => Filter::class
            // Configure your form options here
        ]);
    }
}
