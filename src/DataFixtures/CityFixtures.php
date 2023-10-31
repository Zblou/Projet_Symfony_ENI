<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 5 ; $i++){
            $city = new City();
            $city->setName($faker->city());
            $city->setPostalCode($faker->postcode());
            $manager->persist($city);
            $this->addReference('ville'.$i, $city);
        }
        $manager->flush();
    }


}
