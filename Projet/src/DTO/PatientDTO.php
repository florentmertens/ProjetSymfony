<?php

namespace App\DTO;

use App\Entity\Medecin;
use App\Entity\RendezVous;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     description="PatientDTO model",
 *     title="PatientDTO model"
 * )
 */
class PatientDTO
{
    /**
     * @OA\Property(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @ORM\Column(type="string", length=255)
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
     * @OA\Property(type="object")
     * @ORM\ManyToMany(targetEntity=Medecin::class, mappedBy="patients")
     */
    private $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection|Medecin[]
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function setMedecins(Collection $medecins): self
    {
        $this->medecins = $medecins;
        return $this;
    }
}
