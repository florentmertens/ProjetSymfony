<?php

namespace App\DataFixtures;

use App\Entity\Medecin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedecinFixture extends Fixture
{
    // CREATION FAUSSE DONNEE
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            $medecin1 = (new Medecin())->setNom("MERTENS")->setPrenom("florent")->setNumeroTel("$i")->setAdresse("$i rue jean")->setEmail("florent$i@gmail.com")->setPassword("Test0011$i")->setRoles([])->setSpecialite("dentiste");
            $manager->persist($medecin1);
        }

        for ($i = 1; $i <= 3; $i++) {
            $medecin2 = (new Medecin())->setNom("JEAN")->setPrenom("louis")->setNumeroTel("$i")->setAdresse("$i rue louis")->setEmail("louis$i@gmail.com")->setPassword("Test0011$i")->setRoles([])->setSpecialite("généraliste");
            $manager->persist($medecin2);
        }

        $manager->flush();
    }
}
