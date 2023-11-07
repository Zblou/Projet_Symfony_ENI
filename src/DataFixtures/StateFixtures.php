<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $state1 = new State();
        $state1->setName('Créée');
        $manager->persist($state1);
        $this->addReference('state1', $state1);

        $state2 = new State();
        $state2->setName('Ouverte');
        $manager->persist($state2);
        $this->addReference('state2', $state2);


        $state3 = new State();
        $state3->setName('Clôturée');
        $manager->persist($state3);
        $this->addReference('state3', $state3);

        $state4 = new State();
        $state4->setName('Activité en cours');
        $manager->persist($state4);
        $this->addReference('state4', $state4);

        $state5 = new State();
        $state5->setName('Passée');
        $manager->persist($state5);
        $this->addReference('state5', $state5);

        $state6 = new State();
        $state6->setName('Annulée');
        $manager->persist($state6);
        $this->addReference('state6', $state6);

        $state7 = new State();
        $state7->setName('Historisée');
        $manager->persist($state7);
        $this->addReference('state7', $state7);


        $manager->flush();
    }
}
