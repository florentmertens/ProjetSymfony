<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use App\Mapper\RendezVousMapper;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\Common\Collections\ArrayCollection;
use App\Service\Exception\PatientServiceException;

class PatientService
{
    private $patientRepository;
    private $manager;
    private $patientMapper;
    private $medecinRepository;
    private $rendezVousMapper;

    public function __construct(
        PatientRepository $patientRepository,
        EntityManagerInterface $manager,
        PatientMapper $mapper,
        MedecinRepository $medecinRepository,
        RendezVousMapper $rendezVousMapper
    ) {
        $this->patientRepository = $patientRepository;
        $this->manager = $manager;
        $this->patientMapper = $mapper;
        $this->medecinRepository = $medecinRepository;
        $this->rendezVousMapper = $rendezVousMapper;
    }

    public function persist(Patient $patient, PatientDto $patientDto)
    {
        try {
            $patient = $this->patientMapper->transformePatientDtoToPatientEntity($patientDto, $patient);
            $this->manager->persist($patient);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function delete(Patient $patient)
    {
        try {
            $this->manager->remove($patient);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $patient = $this->repository->find($id);
            return $this->patientMapper->transformePatientEntityToPatientDto($patient);
        } catch (DriverException $e) {
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function removeMedecin(int $idMedecin, PatientDTO $patientDto)
    {
        try {
            $medecin = $this->medecinRepository->find($idMedecin);
            $patient = $this->patientRepository->find($patientDto->getId());
            if ($medecin && $patient) {
                $patient->removeMedecin($medecin);
                $this->manager->persist($patient);
                $this->manager->flush();
            }
        } catch (DriverException $e) {
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchRendezVous(int $idPatient)
    {
        try {
            $patient = $this->patientRepository->find($idPatient);
            $rendezVouss = $patient->getRendezVous();
            $rendezVousDtos = new ArrayCollection();
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDtos[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
            }
            return $rendezVousDtos;
        } catch (DriverException $e) {
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}
