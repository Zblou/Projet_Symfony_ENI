<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class SortiesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 5 ; $i++){
            $sortie = new Sortie();
            $sortie->setNom($faker->words(3));
            $date = $faker->dateTimeBetween('-3 month');
            $sortie->setDateHeureDebut(\DateTimeImmutable::createFromMutable($date));


            $dateDeFin = $faker->dateTimeBetween('now','+2 month');
            $sortie->setDateLimiteInscription(\DateTimeImmutable::createFromMutable($dateDeFin));


            $sortie->setInfosSortie($faker->realText(300));
            $sortie->setDuree(mt_rand(30,240));
            $sortie->setNbInscriptionsMax(mt_rand(2,50));
            $sortie->setEtat($this->getReference('etat'.mt_rand(1,6)));
            $sortie->setCampus($this->getReference('campus'.mt_rand(1,5)));
            $sortie->setLieu($this->getReference('lieu'.mt_rand(1,5)));
            for($i = 1 ; $i <= mt_rand(5,15) ; $i++){
                $sortie->addParticipant($this->getReference('participant'.mt_rand(1,20)));
            }
            $sortie->setOrganisateur($this->getReference('participant'.mt_rand(1,20)));
            $manager->persist($sortie);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [CampusFixtures::class, ParticipantsFixtures::class, PlaceFixtures::class, EtatFixtures::class];
    }
}
