<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MedecinTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getMedecin(string $nom, string $prenom, string $numeroTel, string $adresse, string $email, string $password,  array $roles, string $specialite)
    {
        $medecin = (new Medecin())->setNom($nom)->setPrenom($prenom)->setNumeroTel($numeroTel)->setAdresse($adresse)->setEmail($email)->setPassword($password)->setRoles($roles)->setSpecialite($specialite);
        return $medecin;
    }

    // TEST GETTER AND SETTER

    // TEST NOM
    public function testGetterAndSetterNom()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setNom("MERTENS");
        $this->assertEquals("MERTENS", $medecin->getNom());
    }

    // TEST PRENOM
    public function testGetterAndSetterPrenom()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setPrenom("florent");
        $this->assertEquals("florent", $medecin->getPrenom());
    }

    // TEST NUMEROTEL
    public function testGetterAndSetterNumeroTel()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setNumeroTel("0123456789");
        $this->assertEquals("0123456789", $medecin->getNumeroTel());
    }

    // TEST ADRESSE
    public function testGetterAndSetterAdresse()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setAdresse("01 rue jean");
        $this->assertEquals("01 rue jean", $medecin->getAdresse());
    }

    // TEST EMAIL
    public function testGetterAndSetterEmail()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setEmail("jean@jean.com");
        $this->assertEquals("jean@jean.com", $medecin->getEmail());
    }

    // TEST PASSWORD
    public function testGetterAndSetterPassword()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setPassword("Test0001");
        $this->assertEquals("Test0001", $medecin->getPassword());
    }

    // TEST ROLEs
    public function testGetterAndSetterRoles()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setRoles(["ROLE_USER"]);
        $this->assertEquals(["ROLE_USER"], $medecin->getRoles());
    }

    // TEST SPECIALITE
    public function testGetterAndSetterSpecialite()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $medecin->setSpecialite("généraliste");
        $this->assertEquals("généraliste", $medecin->getSpecialite());
    }

    // TEST RENDEZVOUS
    public function testGetterRendezVous()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $this->assertCount(0, $medecin->getRendezVous());
    }

    public function testAddRendezVou()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $rendezVous = (new RendezVous())->setDate(new DateTime("17-12-2020"))->setHoraire(new DateTime("9:08"));
        $medecin->addRendezVou($rendezVous);
        $this->assertCount(1, $medecin->getRendezVous());
        $this->assertEquals($medecin, $rendezVous->getMedecin());
    }

    public function testRemoveRendezVou()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $rendezVous = (new RendezVous())->setDate(new DateTime("17-12-2020"))->setHoraire(new DateTime("9:08"));
        $medecin->addRendezVou($rendezVous);
        $this->assertCount(1, $medecin->getRendezVous());
        $medecin->removeRendezVou($rendezVous);
        $this->assertCount(0, $medecin->getRendezVous());
        $this->assertEquals(null, $rendezVous->getMedecin());
    }

    // TEST PATIENT
    public function testGetterPatients()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $this->assertCount(0, $medecin->getPatients());
    }

    public function testAddPatient()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $patient = (new Patient())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([]);
        $medecin->addPatient($patient);
        $this->assertCount(1, $medecin->getPatients());
    }

    public function testRemovePatient()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $patient = (new Patient())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([]);
        $medecin->addPatient($patient);
        $this->assertCount(1, $medecin->getPatients());
        $medecin->removePatient($patient);
        $this->assertCount(0, $medecin->getPatients());
        $this->assertEquals(null, $medecin->getPatients()[0]);
    }

    // TEST VALIDATOR

    // TEST NOTBLANK
    public function testNotValideBlankMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ ne peut pas être vide.", $errors[0]->getMessage());
    }

    public function testIsMedecinValide()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST NOM
    public function testNotValideRegexNomMedecin()
    {
        $medecin = $this->getMedecin("mertens6", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsNomMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST PRENOM
    public function testNotValideRegexPrenomMedecin()
    {
        $medecin = $this->getMedecin("mertens", "flor7ent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsPrenomMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST NUMEROTEL
    public function testNotValideRegexNumeroTelMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "012345678d9", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ autorise que des chiffres.", $errors[0]->getMessage());
    }

    public function testIsNumeroTelMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST EMAIL
    public function testNotValideEmailMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Merci de saisir un Email correct.", $errors[0]->getMessage());
    }

    public function testIsEmailMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST PASSWORD
    public function testNotValideRegexPasswordMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", ".", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Votre mot de passe doit faire minimum 8 caractères et doit contenir au moins : 1 chiffre, 1 minuscule, 1 majuscule.", $errors[0]->getMessage());
    }

    public function testIsPasswordMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST SPECIALITE
    public function testNotValideRegexSpecialiteMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généra5liste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsSpecialiteMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", [], "généraliste");
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }
}
