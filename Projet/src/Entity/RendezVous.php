<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $horaire;

    /**
     * @ORM\ManyToOne(targetEntity=Patients::class, inversedBy="RendezVous")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patients;

    /**
     * @ORM\ManyToOne(targetEntity=Medecins::class, inversedBy="RendezVous")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecins;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->horaire;
    }

    public function setHoraire(\DateTimeInterface $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getPatients(): ?Patients
    {
        return $this->patients;
    }

    public function setPatients(?Patients $patients): self
    {
        $this->patients = $patients;

        return $this;
    }

    public function getMedecins(): ?Medecins
    {
        return $this->medecins;
    }

    public function setMedecins(?Medecins $medecins): self
    {
        $this->medecins = $medecins;

        return $this;
    }
}
