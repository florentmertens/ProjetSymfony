<?php

namespace App\Tests\Entity;

use App\Entity\Medecin;
use App\Entity\Patient;
use DateTime;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RendezVousTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getRendezVous(DateTime $date, DateTime $horaire)
    {
        $rendezVous = (new RendezVous())->setDate($date)->setHoraire($horaire);
        return $rendezVous;
    }

    // TEST GETTER AND SETTER

    // TEST DATE
    public function testGetterAndSetterDate()
    {
        $rendezVous = $this->getRendezVous(new DateTime("16-12-2020"), new DateTime("13:05"));
        $rendezVous->setDate(new DateTime("16-12-2020"));
        $this->assertEquals("16-12-2020", $rendezVous->getDate()->format("d-m-Y"));
    }

    // TEST HORAIRE
    public function testGetterAndSetterHoraire()
    {
        $rendezVous = $this->getRendezVous(new DateTime("2020-12-16"), new DateTime("13:05"));
        $rendezVous->setHoraire(new DateTime("13:05"));
        $this->assertEquals("13:05", $rendezVous->getHoraire()->format("H:i"));
    }

    // TEST PATIENT
    public function testGetterAndSetterPatient()
    {
        $rendezVous = $this->getRendezVous(new DateTime("2020-12-16"), new DateTime("13:05"));
        $patient = (new Patient())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([]);
        $rendezVous->setPatient($patient);
        $this->assertEquals($patient, $rendezVous->getPatient());
    }

    // TEST MEDECIN
    public function testGetterAndSetterMedecin()
    {
        $rendezVous = $this->getRendezVous(new DateTime("2020-12-16"), new DateTime("13:05"));
        $medecin = (new Medecin())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([])->setSpecialite("généraliste");
        $rendezVous->setmedecin($medecin);
        $this->assertEquals($medecin, $rendezVous->getmedecin());
    }
}
