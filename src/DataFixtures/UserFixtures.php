<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */

    //Cette fonction pour coder le password

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
     $this->encoder =$encoder;
    }

    public function load(EntityManagerInterface  $em)
    {
     $user= new User();
     $user->setUsername('demo');
     //Cette fonction pour coder le password
     $user->setPassword($this->encoder->encodePassword($user,'demo'));
     $em->persist($user);
     $em->flush();
    }
}
