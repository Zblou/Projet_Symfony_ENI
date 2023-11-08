<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\State;
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
            $trip->setName(implode(" ", $faker->words(3)));
            $date = $faker->dateTimeBetween('-3 month');
            $trip->setDateStartTime(\DateTimeImmutable::createFromMutable($date));


            $endDate = $faker->dateTimeBetween('now','+2 month');
            $trip->setRegistrationDeadLine(\DateTimeImmutable::createFromMutable($endDate));


            $trip->setInfosTrip($faker->realText(300));
            $trip->setDuration(mt_rand(30,240));
            $trip->setNbRegistrationsMax(mt_rand(2,50));

            $trip->setState($this->getReference('state'.mt_rand(1,7)));
            $trip->setCampus($this->getReference('campus'.mt_rand(1,5)));
            $trip->setPlace($this->getReference('place'.mt_rand(1,5)));

            for($j = 1 ; $j <= mt_rand(5,10) ; $j++){
                $trip->addUser($this->getReference('user'.mt_rand(1,20)));
            }
            $trip->setOrganizer($this->getReference('user'.mt_rand(1,20)));
            $manager->persist($trip);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [PlaceFixtures::class, StateFixtures::class, UserFixtures::class];
    }
}
