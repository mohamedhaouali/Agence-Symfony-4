<?php

namespace App\DataFixtures;

use App\Entity\Proprety;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(EntityManagerInterface  $em)
    {
        $faker = Factory::create('fr_FR');
        for ($i =0; $i<100;$i++){
            $property = new Proprety();
            $property
                ->setTitre($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setSurface($faker->numberBetween(20,350))
                ->setRooms($faker->numberBetween(2,10))
                ->setBedrooms($faker->numberBetween(1,9))
                ->setFloor($faker->numberBetween(0,15))
                ->setPrice($faker->numberBetween(100000,10000000))
                ->setHeat($faker->numberBetween(0,count(Proprety::Heat) -1))
                ->setCity($faker->city)
                ->setAdress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold(false);
            $em->persist($property);

        }


        $em->flush();
    }
}
