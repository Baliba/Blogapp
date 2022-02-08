<?php

namespace App\DataFixtures;
use App\Entity\News;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public $en;
    public UserRepository $urep;
    public function __construct(UserPasswordHasherInterface $enc, UserRepository  $urep ){
       $this->en = $enc;
       $this->urep = $urep;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
          $gen = Faker\Factory::create("fr_FR");
          for($i = 0; $i<5;$i++){
                $user = new User();
                $user->setId($i+1);
                $pass = $this->en->hashPassword($user,"password");
                $user->setFullName($gen->firstName())  
                ->setUsername($gen->email) 
                ->setPassword($pass);
                 $manager->persist($user);
          }
        $manager->flush();
        $us = $this->urep->findAll();
        for ($j = 0; $j < sizeof($us); $j++) {
            for ($i = 0; $i < 10; $i++) {
                $n = new News();
                $n->setUser($us[$j]);
                $n->setTitle($gen->company);
                $n->setContent($gen->address);
                $n->setCover('https://via.placeholder.com/350X350');
                $n->setDateCreated($gen->dateTime);
                $n->setStatus("PUBLISH");
                $manager->persist($n);
            }
        }
        $manager->flush();
    }
}
