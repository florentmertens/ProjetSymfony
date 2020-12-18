<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin implements UserInterface
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
     * @var string The hashed password
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
     * @ORM\Column(type="json")
     */
    private $roles = [];

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
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="medecin")
     */
    private $RendezVous;

    /**
     * @ORM\ManyToMany(targetEntity=Patient::class, inversedBy="medecins")
     */
    private $patients;

    public function __construct()
    {
        $this->RendezVous = new ArrayCollection();
        $this->patients = new ArrayCollection();
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

    /**
     * @see UserInterface
     */
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
            $rendezVou->setMedecin($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): self
    {
        if ($this->RendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getMedecin() === $this) {
                $rendezVou->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
        }

        return $this;
    }

    public function removePatient(patient $patient): self
    {
        $this->patients->removeElement($patient);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
}
