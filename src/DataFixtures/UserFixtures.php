<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Participant de test
        $testUser = new User();
        $testUser->setName('test');
        $testUser->setPseudo('test');
        $testUser->setCampus($this->getReference('campus'.mt_rand(1,5)));
        $testUser->setEmail('test@test.fr');
        $testUser->setPassword($this->userPasswordHasher->hashPassword($testUser,'123456'));
        $testUser->setFirstname('test');
        $testUser->setActive(true);
        $testUser->setPhone('0789654725');
        $manager->persist($testUser);


        for($i = 1 ; $i <= 20 ; $i++){
            $user = new User();
            $user->setName($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setEmail($faker->email());
            //$password = $this->userPasswordHasher->hashPassword($participant, '123456');
            $user->setPassword($this->userPasswordHasher->hashPassword($user,'123465'));
            $user->setCampus($this->getReference('campus'.mt_rand(1,5)));
            $user->setPhone($faker->phoneNumber());
            $user->setPseudo($faker->userName());
            $user->setActive(true);
            $manager->persist($user);
            $this->addReference('user'.$i, $user);
        }

        $manager->flush();
    }
}
