<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PatientFixture extends Fixture
{
    // CREATION FAUSSE DONNEE
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            $patient1 = (new Patient())->setNom("DEVILLE")->setPrenom("marie")->setNumeroTel("$i")->setAdresse("$i boulevard forest")->setEmail("marie$i@gmail.com")->setPassword("Test0011$i")->setRoles([]);
            $manager->persist($patient1);
        }

        for ($i = 1; $i <= 3; $i++) {
            $patient2 = (new Patient())->setNom("PEREZ")->setPrenom("bastien")->setNumeroTel("$i")->setAdresse("$i avenue hugo")->setEmail("bastien$i@gmail.com")->setPassword("Test0011$i")->setRoles([]);
            $manager->persist($patient2);
        }

        $manager->flush();
    }
}
