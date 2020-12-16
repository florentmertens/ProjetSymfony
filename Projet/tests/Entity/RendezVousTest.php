<?php

namespace App\Tests\Entity;

use App\Entity\Medecins;
use App\Entity\Patients;
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
        $rendezVous = (new RendezVous())->setDate($date)->setHoraire($horaire)->setPatients(new Patients)->setMedecins(new Medecins);
        return $rendezVous;
    }

    // TEST GETTER AND SETTER

    // TEST DATE
    public function testGetterAndSetterDate()
    {
        $rendezVous = $this->getRendezVous(new DateTime("16-12-2020"), new DateTime("13:05"), new Patients, new Medecins);
        $rendezVous->setDate(new DateTime("16-12-2020"));
        $this->assertEquals("16-12-2020", $rendezVous->getDate()->format("d-m-Y"));
    }

    // TEST HORAIRE
    public function testGetterAndSetterHoraire()
    {
        $rendezVous = $this->getRendezVous(new DateTime("2020-12-16"), new DateTime("13:05"), new Patients, new Medecins);
        $rendezVous->setHoraire(new DateTime("13:05"));
        $this->assertEquals("13:05", $rendezVous->getHoraire()->format("H:i"));
    }
}
