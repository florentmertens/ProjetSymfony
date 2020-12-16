<?php

namespace App\Tests\Entity;

use App\Entity\Medecins;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

class MedecinsTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getMedecin(string $nom, string $prenom, string $numeroTel, string $adresse, string $email, string $password, string $role, string $specialite, RendezVous $rendezVous)
    {
        $medecin = (new Medecins())->setNom($nom)->setPrenom($prenom)->setNumeroTel($numeroTel)->setAdresse($adresse)->setEmail($email)->setPassword($password)->setRole($role)->setSpecialite($specialite)->addRendezVou($rendezVous);
        return $medecin;
    }

    // TEST GETTER AND SETTER

    // TEST NOM
    public function testGetterAndSetterNom()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setNom("MERTENS");
        $this->assertEquals("MERTENS", $medecin->getNom());
    }

    // TEST PRENOM
    public function testGetterAndSetterPrenom()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setPrenom("florent");
        $this->assertEquals("florent", $medecin->getPrenom());
    }

    // TEST NUMEROTEL
    public function testGetterAndSetterNumeroTel()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setNumeroTel("0123456789");
        $this->assertEquals("0123456789", $medecin->getNumeroTel());
    }

    // TEST ADRESSE
    public function testGetterAndSetterAdresse()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setAdresse("01 rue jean");
        $this->assertEquals("01 rue jean", $medecin->getAdresse());
    }

    // TEST EMAIL
    public function testGetterAndSetterEmail()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setEmail("jean@jean.com");
        $this->assertEquals("jean@jean.com", $medecin->getEmail());
    }

    // TEST PASSWORD
    public function testGetterAndSetterPassword()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setPassword("Test0001");
        $this->assertEquals("Test0001", $medecin->getPassword());
    }

    // TEST ROLE
    public function testGetterAndSetterRole()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setRole("ROLE_USER");
        $this->assertEquals("ROLE_USER", $medecin->getRole());
    }

    // TEST SPECIALITE
    public function testGetterAndSetterSpecialite()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $medecin->setSpecialite("généraliste");
        $this->assertEquals("généraliste", $medecin->getSpecialite());
    }

    // TEST VALIDATOR

    // TEST NOTBLANK
    public function testNotValideBlankMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ ne peut pas être vide.", $errors[0]->getMessage());
    }

    public function testIsMedecinValide()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST NOM
    public function testNotValideRegexNomMedecin()
    {
        $medecin = $this->getMedecin("mertens6", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsNomMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST PRENOM
    public function testNotValideRegexPrenomMedecin()
    {
        $medecin = $this->getMedecin("mertens", "flor7ent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsPrenomMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST NUMEROTEL
    public function testNotValideRegexNumeroTelMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "012345678d9", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Ce champ autorise que des chiffres.", $errors[0]->getMessage());
    }

    public function testIsNumeroTelMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST EMAIL
    public function testNotValideEmailMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Merci de saisir un Email correct.", $errors[0]->getMessage());
    }

    public function testIsEmailMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST PASSWORD
    public function testNotValideRegexPasswordMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", ".", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Votre mot de passe doit faire minimum 8 caractères et doit contenir au moins : 1 chiffre, 1 minuscule, 1 majuscule.", $errors[0]->getMessage());
    }

    public function testIsPasswordMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }

    // TEST SPECIALITE
    public function testNotValideRegexSpecialiteMedecin()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généra5liste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(1, $errors);
        $this->assertEquals("Les chiffres ne sont pas autorisé.", $errors[0]->getMessage());
    }

    public function testIsSpecialiteMedecinValid()
    {
        $medecin = $this->getMedecin("mertens", "florent", "0123456789", "", "mertens.florent00@gmail.com", "Test0001", "", "généraliste", new RendezVous());
        $errors = $this->validator->validate($medecin);
        $this->assertCount(0, $errors);
    }
}
