<?php

namespace App\DTO;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="RendezVousDTO model",
 *     title="RendezVousDTO model"
 * )
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVousDTO
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
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @OA\Property(type="string")
     * @ORM\Column(type="time")
     */
    private $horaire;

    /**
     * @OA\Property(type="integer")
     */
    private $patientId;

    /**
     * @OA\Property(type="integer")
     */
    private $medecinId;



    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of horaire
     */
    public function getHoraire(): DateTime
    {
        return $this->horaire;
    }

    /**
     * Set the value of horaire
     *
     * @return  self
     */
    public function setHoraire(DateTime $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get the value of int
     */
    public function getPatientId(): int
    {
        return $this->patientId;
    }

    /**
     * Set the value of int
     *
     * @return  self
     */
    public function setPatientId(int $patientId): self
    {
        $this->patientId = $patientId;

        return $this;
    }

    /**
     * Get the value of int
     */
    public function getMedecinId(): int
    {
        return $this->medecinId;
    }

    /**
     * Set the value of int
     *
     * @return  self
     */
    public function setMedecinID(int $medecinId): self
    {
        $this->medecinId = $medecinId;

        return $this;
    }
}
