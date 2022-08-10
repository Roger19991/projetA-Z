<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Blogpost;
use App\Entity\Peinture;
use App\Entity\Categorie;
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
        $user = new User();

        $user->setEmail('User@test.com')
             ->setPrenom($faker->firstName())
             ->setNom($faker->lastName())
             ->setTelephone($faker->phoneNumber())
             ->setApropos($faker->text())
             ->setRoles(['ROLE_PEINTRE'])
            
             ->setInstagram('instagram');


        $password = $this->encoder->hashPassword($user, 'password');
        $user->setpassword($password);

       $manager->persist($user);

       //creation de 10 blogpost
       for ($i=0; $i < 10; $i++) { 

        $Blogpost =new Blogpost();

        $Blogpost->setTitre($faker->words(3, true))
                 ->setCreateAt($faker->dateTimeBetween('-6 month', 'now'))
                 ->setContenu($faker->Text(350))
                 ->setSlug($faker->slug(3))
                 ->setUser($user);

        $manager->persist($Blogpost);

        
           }

           //creation de 5 categories
           for ($k=0; $k < 5; $k++) {
                $categorie = new Categorie();
    
                $categorie->setNom($faker->word())
                          ->setDescription($faker->word())
                          ->setSlug($faker->slug());
    
    
                $manager->persist($categorie);
    
                //creation de deux peinture/categories
            for ($j=0; $j < 2; $j++) {
                $peinture = new Peinture();

                $peinture->setNom($faker->words(3, true))
                ->setLargeur($faker->randomFloat(2, 20, 60))
                ->setHauteur($faker->randomFloat(2, 20, 60))
                ->setEnvente($faker->randomElement([true, false]))
                ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                ->setCReateAt($faker->dateTimeBetween('-6 month', 'now'))
                ->setDescription($faker->text())
                ->setPortfolio($faker->randomElement([true, false]))
                ->setSlug($faker->slug())
                ->setFile('/img/placeholder.jpg')
                ->addCategorie($categorie)
                ->setprix($faker->randomFloat(2, 100, 9999))
                ->setUser($user);

            }



           }

        $manager->flush();
    }
}
