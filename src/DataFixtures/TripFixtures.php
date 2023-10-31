<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Trip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class TripFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 5 ; $i++){
            $trip = new Trip();
            $trip->setName($faker->words(3));
            $date = $faker->dateTimeBetween('-3 month');
            $trip->setDateStartTime(\DateTimeImmutable::createFromMutable($date));


            $endDate = $faker->dateTimeBetween('now','+2 month');
            $trip->setRegistrationDeadLine(\DateTimeImmutable::createFromMutable($endDate));


            $trip->setInfosTrip($faker->realText(300));
            $trip->setDuration(mt_rand(30,240));
            $trip->setNbRegistrationsMax(mt_rand(2,50));
            $trip->setState($this->getReference('state'.mt_rand(1,6)));
            $trip->setCampus($this->getReference('campus'.mt_rand(1,5)));
            $trip->setPlace($this->getReference('place'.mt_rand(1,5)));
            for($i = 1 ; $i <= mt_rand(5,15) ; $i++){
                $trip->addParticipant($this->getReference('participant'.mt_rand(1,20)));
            }
            $trip->setOrganizer($this->getReference('participant'.mt_rand(1,20)));
            $manager->persist($trip);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [CampusFixtures::class, ParticipantsFixtures::class, PlaceFixtures::class, StateFixtures::class];
    }
}