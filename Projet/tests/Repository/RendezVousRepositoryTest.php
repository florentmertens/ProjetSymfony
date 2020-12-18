<?php

namespace App\Tests\Repository;

use DateTime;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\RendezVousFixture;
use App\Repository\RendezVousRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RendezVousRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    private $repository;

    protected function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get(RendezVousRepository::class);
    }

    private function getPatient()
    {
        $patient = (new Patient())->setNom("PEREZ")->setPrenom("bastien")->setNumeroTel("0123456789")->setAdresse("10 avenue hugo")->setEmail("bastien$2@gmail.com")->setPassword("Test00114")->setRoles([]);
        return $patient;
    }

    private function getMedecin()
    {
        $medecin = (new Medecin())->setNom("MERTENS")->setPrenom("florent")->setNumeroTel("1")->setAdresse("17 rue jean 1")->setEmail("florent1@gmail.com")->setPassword("Test00111")->setRoles([])->setSpecialite("dentiste");
        return $medecin;
    }

    public function testRendezVousFindAll()
    {
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVous = $this->repository->findAll();
        $this->assertCount(10, $rendezVous);
    }

    public function testRendezVousFindBy()
    {
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVous = $this->repository->findBy(["date" => new DateTime("15-10-2020")]);
        $this->assertCount(5, $rendezVous);
    }

    public function testRendezVousFindOneBy()
    {
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVous = $this->repository->findOneBy(["date" => new DateTime("11-12-2020")]);
        $this->assertNotNull($rendezVous);
    }

    public function testRendezVousFind()
    {
        $this->loadFixtures([RendezVousFixture::class]);
        $rendezVous = $this->repository->find("8");
        $this->assertNotNull($rendezVous);
    }

    public function testManagerPersist()
    {
        $patient = $this->getPatient();
        $medecin = $this->getMedecin();
        $this->loadFixtures([AppFixtures::class]);
        $rendezVous = (new RendezVous())->setDate(new DateTime("18-12-2020"))->setHoraire(new DateTime("14:00"))->setPatient($patient)->setMedecin($medecin);
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($rendezVous);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }

    protected function tearDown()
    {
        $this->loadFixtures([AppFixtures::class]);
    }
}
