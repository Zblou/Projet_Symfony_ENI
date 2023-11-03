<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Trip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

;

class CampusFixtures extends Fixture

{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');


        for($i = 1; $i <= 5 ; $i++){
           $campus = new Campus();
           $campus->setName($faker->city());
           //$campus->addTripsCampus($this->getReference('sortie'.mt_rand(1,5)));
           $this->addReference('campus'.$i, $campus);
           $manager->persist($campus);
        }

        $manager->flush();
    }




}
