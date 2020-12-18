<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RendezVousFixture extends Fixture
{
    // CREATION FAUSSE DONNEE
    public function load(ObjectManager $manager)
    {
        $patient = (new Patient())->setNom("PEREZ")->setPrenom("bastien")->setNumeroTel("0123456789")->setAdresse("10 avenue hugo")->setEmail("bastien$2@gmail.com")->setPassword("Test00114")->setRoles([]);
        $medecin = (new Medecin())->setNom("MERTENS")->setPrenom("florent")->setNumeroTel("1")->setAdresse("17 rue jean 1")->setEmail("florent1@gmail.com")->setPassword("Test00111")->setRoles([])->setSpecialite("dentiste");
        for ($i = 1; $i <= 5; $i++) {
            $rendezVous = (new RendezVous())->setDate(new DateTime("1$i-12-2020"))->setHoraire(new DateTime("1$i:00"))->setPatient($patient)->setMedecin($medecin);
            $manager->persist($rendezVous);
        }

        for ($i = 1; $i <= 5; $i++) {
            $rendezVous = (new RendezVous())->setDate(new DateTime("15-10-2020"))->setHoraire(new DateTime("1$i:30"))->setPatient($patient)->setMedecin($medecin);
            $manager->persist($rendezVous);
        }

        $manager->flush();
    }
}
