<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture

{
          private $encoder;
          
          public function __construct(UserPasswordHasherInterface $encoder,)

          {
            $this->encoder = $encoder;
           
          }

        

    public function load(ObjectManager $manager)

    {
        //utilisation de faker
        $faker = Factory::create('fr_FR'); 

        //creation d'un utilisateur
        $User = new User();

        $User->setEmail('User@test.com')
             ->setPrenom($faker->firstName())
             ->setNom($faker->lastName())
             ->setTelephone($faker->phoneNumber())
             ->setApropos($faker->text())
             ->setRoles(['ROLE_PEINTRE'])
            
             ->setInstagram('instagram');


        $password = $this->encoder->hashPassword($User, 'password');
        $User->setpassword($password);

       $manager->persist($User);

        $manager->flush();
    }
}
