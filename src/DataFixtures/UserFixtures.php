<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        for($i=1; $i<5; $i++){
            $user = new User();
            $user->setUsername($faker->name())
                 ->setEmail($faker->email())
                 ->setPassword($faker->password());

            $manager->persist($user);
        }
    $manager->flush();
}
}
