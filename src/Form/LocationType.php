<?php

namespace App\Form;

use App\Entity\Location;
use App\Repository\LocationRepository;

use App\Entity\Images;
use App\Repository\ImagesRepository;

use App\Entity\Categorie;
use App\Repository\CategorieRepositorie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denomination')
            ->add('categorie', EntityType::class, [
                // looks for choices from this entity
                    'class' => Categorie::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'titre'])
            ->add('photo')
            ->add('images', FileType::class, [
                'label'=> false,
                'multiple' => true,
                'mapped' => false,
                'required'=> false ])

        //  ->add('createdAt')
            ->add('description')
            ->add('surface')
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'F1'=> 'F1',
                    'F2'=> 'F2',
                    'F3'=> 'F3',
                    'F4'=> 'F4',
                    'F5'=> 'F5',
                    'F6'=> 'F6',
                )))
            ->add('chambre', ChoiceType::class, array(
                    'choices' => array(
                        '1'=> '1',
                        '2'=> '2',
                        '3'=> '3',
                        '4'=> '4',
                        '5'=> '5',
                        '6'=> '6',
                    )))
            ->add('etage')
            ->add('prix')
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('pays')
            ->add('accessibility', ChoiceType::class, array(
                'choices' => array(
                    'Oui'=> 'oui',
                )))   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
