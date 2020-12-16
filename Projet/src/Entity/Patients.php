<?php

namespace App\Entity;

use App\Repository\PatientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientsRepository::class)
 */
class Patients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="patients")
     */
    private $RendezVous;

    public function __construct()
    {
        $this->RendezVous = new ArrayCollection();
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVous(): Collection
    {
        return $this->RendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): self
    {
        if (!$this->RendezVous->contains($rendezVou)) {
            $this->RendezVous[] = $rendezVou;
            $rendezVou->setPatients($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): self
    {
        if ($this->RendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPatients() === $this) {
                $rendezVou->setPatients(null);
            }
        }

        return $this;
    }
}
