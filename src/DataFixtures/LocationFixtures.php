<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    // $product = new Product();
    // $manager->persist($product);
    
        $faker = \Faker\Factory::create('fr_FR');
    // Creer occurence de 10 Categroie
    for($i=1; $i<5; $i++){
        $categorie = new Categorie();
        $categorie->setTitre($faker->sentence())
                  ->setResume($faker->text($maxNbChars = 10));

        $manager->persist($categorie);

    // Mainteannt je cree mes Bien Locatifs
        for($j=1; $j<10; $j++){
            $location = new Location();
            $location->setDenomination($faker->sentence($nb = 5, $asText = false))
                        ->setCategorie($categorie)
                        ->setPhoto($faker->imageUrl($width = 640, $height = 480) )
                        ->setCreatedAt(new \DateTime())
                        ->setDescription($faker->text($maxNbChars = 200))
                        ->setSurface($faker->numberBetween(10,500))
                        ->setType($faker->numberBetween(1,6))
                        ->setChambre($faker->numberBetween(1,7))
                        ->setEtage($faker->numberBetween(0,10))
                        ->setPrix($faker->numberBetween(200,300))
                        ->setAdresse($faker->streetAddress())
                        ->setCp($faker->postcode())
                        ->setVille($faker->city())
                        ->setPays($faker->country($faker->locale))
                        ->setAccessibility( $faker->boolean);
            $manager->persist($location);
        }
    }
$manager->flush();
}
}
