<?php

namespace App\Tests\Repository;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\PatientFixture;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    private $repository;

    protected function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get(PatientRepository::class);
    }

    public function testPatientFindAll()
    {
        $this->loadFixtures([PatientFixture::class]);
        $patient = $this->repository->findAll();
        $this->assertCount(6, $patient);
    }

    public function testPatientFindBy()
    {
        $this->loadFixtures([PatientFixture::class]);
        $patient = $this->repository->findBy(["nom" => "PEREZ"]);
        $this->assertCount(3, $patient);
    }

    public function testPatientFindOneBy()
    {
        $this->loadFixtures([PatientFixture::class]);
        $patient = $this->repository->findOneBy(["email" => "marie3@gmail.com"]);
        $this->assertNotNull($patient);
    }

    public function testPatientFind()
    {
        $this->loadFixtures([PatientFixture::class]);
        $patient = $this->repository->find("6");
        $this->assertNotNull($patient);
    }


    public function testManagerPersist()
    {
        $patient = (new Patient())->setNom("PEREZ")->setPrenom("bastien")->setNumeroTel("0123456789")->setAdresse("10 avenue hugo")->setEmail("bastien$2@gmail.com")->setPassword("Test00114")->setRoles([]);
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($patient);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }

    protected function tearDown()
    {
        $this->loadFixtures([AppFixtures::class]);
    }
}
