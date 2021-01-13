<?php

namespace App\DTO;


use App\Entity\Patient;
use App\Entity\RendezVous;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     description="MedecinDTO model",
 *     title="MedecinDTO model"
 * )
 */
class MedecinDTO
{
    /**
     * @OA\Property(type="integer")
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Regex(
     *      pattern = "/^\D+$/",
     *      message = "Les chiffres ne sont pas autorisé."
     * )
     */
    private $nom;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Regex(
     *      pattern = "/^\D+$/",
     *      message = "Les chiffres ne sont pas autorisé."
     * )
     */
    private $prenom;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Regex(
     *      pattern = "/^\d+$/",
     *      message = "Ce champ autorise que des chiffres."
     * )
     */
    private $numeroTel;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Email(
     *      message = "Merci de saisir un Email correct."
     * )
     */
    private $email;

    /**
     * @OA\Property(type="string")
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Regex(
     *      pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/",
     *      message = "Votre mot de passe doit faire minimum 8 caractères et doit contenir au moins : 1 chiffre, 1 minuscule, 1 majuscule."
     * )
     */
    private $password;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champ ne peut pas être vide."
     * )
     * @Assert\Regex(
     *      pattern = "/^\D+$/",
     *      message = "Les chiffres ne sont pas autorisé."
     * )
     */
    private $specialite;

    /**
     * @OA\Property(type="object")
     * @ORM\ManyToMany(targetEntity=Patient::class, inversedBy="medecins")
     */
    private $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumeroTel(): ?string
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(string $numeroTel): self
    {
        $this->numeroTel = $numeroTel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function setPatients(Collection $patients): self
    {
        $this->patients = $patients;
        return $this;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
        }

        return $this;
    }
}
