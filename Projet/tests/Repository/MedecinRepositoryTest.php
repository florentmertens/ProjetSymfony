<?php

namespace App\Tests\Repository;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\MedecinFixture;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MedecinRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    private $repository;

    protected function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get(MedecinRepository::class);
    }

    public function testMedecinFindAll()
    {
        $this->loadFixtures([MedecinFixture::class]);
        $medecin = $this->repository->findAll();
        $this->assertCount(6, $medecin);
    }

    public function testMedecinFindBy()
    {
        $this->loadFixtures([MedecinFixture::class]);
        $medecin = $this->repository->findBy(["specialite" => "dentiste"]);
        $this->assertCount(3, $medecin);
    }

    public function testMedecinFindOneBy()
    {
        $this->loadFixtures([MedecinFixture::class]);
        $medecin = $this->repository->findOneBy(["email" => "louis1@gmail.com"]);
        $this->assertNotNull($medecin);
    }

    public function testMedecinFind()
    {
        $this->loadFixtures([MedecinFixture::class]);
        $medecin = $this->repository->find("4");
        $this->assertNotNull($medecin);
    }

    public function testManagerPersist()
    {
        $this->loadFixtures([AppFixtures::class]);
        $medecin = (new Medecin())->setNom("MERTENS")->setPrenom("florent")->setNumeroTel("1")->setAdresse("17 rue jean 1")->setEmail("florent1@gmail.com")->setPassword("Test00111")->setRoles([])->setSpecialite("dentiste");
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($medecin);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());
    }
    protected function tearDown()
    {
        $this->loadFixtures([AppFixtures::class]);
    }
}
