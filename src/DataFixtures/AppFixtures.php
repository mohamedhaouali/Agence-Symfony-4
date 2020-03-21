<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    public function load(EntityManagerInterface  $em)
    {
        // $product = new Product();
        // $manager->persist($product);

        $em->flush();
    }
}
