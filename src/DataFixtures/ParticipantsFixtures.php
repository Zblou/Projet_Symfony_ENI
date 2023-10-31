<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
{
}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1 ; $i <= 20 ; $i++){
            $participant = new Participant();
            $participant->setName($faker->lastName());
            $participant->setFirstname($faker->firstName());
            $participant->setMail($faker->email());
            //$password = $this->userPasswordHasher->hashPassword($participant, '123456');
            $participant->setPassword('123456');
            $participant->setCampus($this->getReference('campus'.mt_rand(1,5)));
            $participant->setPhone($faker->phoneNumber());
            $participant->setPseudo($faker->userName());
            $participant->setActive(true);
            $manager->persist($participant);
            $this->addReference('participant'.$i, $participant);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [CampusFixtures::class];
    }
}
