<?php

namespace App\Tests\Entity;

use App\Entity\Patients;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;


class PatientsTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPatient(string $nom, string $prenom, string $numeroTel, string $adresse, string $email, string $password, string $role, RendezVous $rendezVous)
    {
        $patient = (new Patients())->setNom($nom)->setPrenom($prenom)->setNumeroTel($numeroTel)->setAdresse($adresse)->setEmail($email)->setPassword($password)->setRole($role)->addRendezVou($rendezVous);
        return $patient;
    }

    // TEST GETTER AND SETTER

    // TEST NOM
    public function testGetterAndSetterNom()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setNom("MERTENS");
        $this->assertEquals("MERTENS", $patient->getNom());
    }

    // TEST PRENOM
    public function testGetterAndSetterPrenom()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setPrenom("florent");
        $this->assertEquals("florent", $patient->getPrenom());
    }

    // TEST NUMEROTEL
    public function testGetterAndSetterNumeroTel()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setNumeroTel("0135498725");
        $this->assertEquals("0135498725", $patient->getNumeroTel());
    }

    // TEST ADRESSE
    public function testGetterAndSetterAdresse()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setAdresse("01 rue jean");
        $this->assertEquals("01 rue jean", $patient->getAdresse());
    }

    // TEST EMAIL
    public function testGetterAndSetterEmail()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setEmail("jean@jean.com");
        $this->assertEquals("jean@jean.com", $patient->getEmail());
    }

    // TEST PASSWORD
    public function testGetterAndSetterPassword()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setPassword("test");
        $this->assertEquals("test", $patient->getPassword());
    }

    // TEST ROLE
    public function testGetterAndSetterRole()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "test", "", new RendezVous());
        $patient->setRole("ROLE_USER");
        $this->assertEquals("ROLE_USER", $patient->getRole());
    }

    // TEST VALIDATOR

    // TEST NOTBLANK 
    public function testNotValideBlankPatient()
    {
        $patient = $this->getPatient("", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ ne peut pas être vide.", $errors[0]->getMessage());
    }

    public function testIsPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST NOM 
    public function testNotValideNomPatient()
    {
        $patient = $this->getPatient("mertens4", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsNomPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST PRENOM 
    public function testNotValidePrenomPatient()
    {
        $patient = $this->getPatient("mertens", "flor8ent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsPrenomPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST NUMEROTEL
    public function testNotValideNumeroTelPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456d789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ autorise que des chiffres.", $errors[0]->getMessage());
    }

    public function testIsNumeroTelPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST EMAIL
    public function testNotValideEmailPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Merci de saisir un Email correct.", $errors[0]->getMessage());
    }

    public function testIsEmailPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }

    // TEST PASSWORD
    public function testNotValidePasswordPatient()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Tet0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Votre mot de passe doit faire minimum 8 caractères et doit contenir au moins : 1 chiffre, 1 minuscule, 1 majuscule.", $errors[0]->getMessage());
    }

    public function testIsPasswordPatientValide()
    {
        $patient = $this->getPatient("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0011", "", new RendezVous());
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }
}
