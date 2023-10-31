<?php

namespace App\DataFixtures;

use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class PlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 5 ; $i++){
            $lieu = new Place();
            $lieu->setVille($this->getReference('ville'.mt_rand(1,5)));
            $lieu->setNom($faker->words(asText: true));
            $lieu->setRue($faker->address());
            $lieu->setLatitude($faker->latitude());
            $lieu->setLongitude($faker->longitude());
            $manager->persist($lieu);
            $this->addReference('lieu'.$i, $lieu);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [CityFixtures::class];
    }
}
