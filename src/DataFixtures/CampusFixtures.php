<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');


        $campus = new Campus();
        $campus->setNom($faker->city());
        $campus->addStudent(new Participant());
        $campus->addSortiesCampus(new Trip());
        //$this->addReference('campus'.$i, $campus);
        $manager->persist($campus);

/*
        for($i = 1; $i <= 5 ; $i++){
           $campus = new Campus();
           $campus->setNom($faker->city());
           $campus->addStudent($this->getReference('student'.mt_rand(1,20)));
           $campus->addSortiesCampus($this->getReference('sortie'.mt_rand(1,5)));
           $this->addReference('campus'.$i, $campus);
           $manager->persist($campus);
        }*/

        $manager->flush();
    }

/*
    public function getDependencies():array
    {
        return [ParticipantsFixtures::class, SortiesFixtures::class];
    }*/
}
