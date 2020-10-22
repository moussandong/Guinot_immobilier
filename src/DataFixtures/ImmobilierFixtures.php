<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Immobilier;

class ImmobilierFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    // $product = new Product();
    // $manager->persist($product);
   
    // Creer occurence de 20 
        for($i=1; $i<100; $i++){
            $immobilier = new Immobilier();
            $immobilier->setTitre("Titre Livre n°$i")
                        ->setDescription("... sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellemen")
                        ->setPhoto("http://placehold.it/300x200")
                        ->setCreatedAt(new \DateTime());
            $manager->persist($immobilier);
        }
        $manager->flush();
    }
}
