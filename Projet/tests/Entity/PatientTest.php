<?php

namespace App\Tests\Entity;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;


class PatientTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPatient(string $nom, string $prenom, string $numeroTel, string $adresse, string $email, string $password, array $roles)
    {
        $patient = (new Patient())->setNom($nom)->setPrenom($prenom)->setNumeroTel($numeroTel)->setAdresse($adresse)->setEmail($email)->setPassword($password)->setRoles($roles);
        return $patient;
    }

    // TEST GETTER AND SETTER

    // TEST NOM
    public function testGetterAndSetterNom()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setNom("MERTENS");
        $this->assertEquals("MERTENS", $patient->getNom());
    }

    // TEST PRENOM
    public function testGetterAndSetterPrenom()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setPrenom("florent");
        $this->assertEquals("florent", $patient->getPrenom());
    }

    // TEST NUMEROTEL
    public function testGetterAndSetterNumeroTel()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setNumeroTel("0135498725");
        $this->assertEquals("0135498725", $patient->getNumeroTel());
    }

    // TEST ADRESSE
    public function testGetterAndSetterAdresse()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setAdresse("01 rue jean");
        $this->assertEquals("01 rue jean", $patient->getAdresse());
    }

    // TEST EMAIL
    public function testGetterAndSetterEmail()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setEmail("jean@jean.com");
        $this->assertEquals("jean@jean.com", $patient->getEmail());
    }

    // TEST PASSWORD
    public function testGetterAndSetterPassword()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setPassword("test");
        $this->assertEquals("test", $patient->getPassword());
    }

    // TEST ROLEs
    public function testGetterAndSetterRoles()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $patient->setRoles(["ROLE_USER"]);
        $this->assertEquals(["ROLE_USER"], $patient->getRoles());
    }

    // TEST RENDEZVOUS
    public function testGetterRendezVous()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $this->assertCount(0, $patient->getRendezVous());
    }

    public function testAddRendezVou()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", []);
        $rendezVous = (new RendezVous())->setDate(new DateTime("17-12-2020"))->setHoraire(new DateTime("11:10"));
        $patient->addRendezVou($rendezVous);
        $this->assertCount(1, $patient->getRendezVous());
        $this->assertEquals($patient, $rendezVous->getPatient());
    }

    public function testRemoveRendezVou()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", []);
        $rendezVous = (new RendezVous())->setDate(new DateTime("17-12-2020"))->setHoraire(new DateTime("11:10"));
        $patient->addRendezVou($rendezVous);
        $this->assertCount(1, $patient->getRendezVous());
        $patient->removeRendezVou($rendezVous);
        $this->assertCount(0, $patient->getRendezVous());
        $this->assertEquals(null, $rendezVous->getPatient());
    }

    // TEST MEDECIN
    public function testGetterMedecins()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", []);
        $this->assertCount(0, $patient->getMedecins());
    }

    public function testAddMedecin()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", []);
        $medecin = (new Medecin())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([])->setSpecialite("généraliste");
        $patient->addMedecin($medecin);
        $this->assertCount(1, $patient->getMedecins());
        $this->assertEquals($patient, $medecin->getPatients()[0]);
    }

    public function testRemoveMedecin()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", []);
        $medecin = (new Medecin())->setNom("mertens")->setPrenom("florent")->setNumeroTel("0123456789")->setAdresse("")->setEmail("mertens.florent00@gmail.com")->setPassword("Test0011")->setRoles([])->setSpecialite("généraliste");
        $patient->addMedecin($medecin);
        $this->assertCount(1, $patient->getMedecins());
        $patient->removeMedecin($medecin);
        $this->assertCount(0, $patient->getMedecins());
        $this->assertEquals(null, $medecin->getPatients()[0]);
    }

    // TEST VALIDATOR

    // TEST NOTBLANK 
    public function testNotValideBlankPatient()
    {
        $patient = $this->getPatient("", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ ne peut pas être vide.", $errors[0]->getMessage());
    }

    public function testIsPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST NOM 
    public function testNotValideNomPatient()
    {
        $patient = $this->getPatient("mertens4", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsNomPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST PRENOM 
    public function testNotValidePrenomPatient()
    {
        $patient = $this->getPatient("mertens", "flor8ent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsPrenomPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST NUMEROTEL
    public function testNotValideNumeroTelPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456d789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ autorise que des chiffres.", $errors[0]->getMessage());
    }

    public function testIsNumeroTelPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST EMAIL
    public function testNotValideEmailPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Merci de saisir un Email correct.", $errors[0]->getMessage());
    }

    public function testIsEmailPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST PASSWORD
    public function testNotValidePasswordPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Tet0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Votre mot de passe doit faire minimum 8 caractères et doit contenir au moins : 1 chiffre, 1 minuscule, 1 majuscule.", $errors[0]->getMessage());
    }

    public function testIsPasswordPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", []);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }
}
