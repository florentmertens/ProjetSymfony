<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PatientServiceException;
use App\Mapper\PatientMapper;

class PatientService
{
    private $repository;
    private $manager;
    private $patientMapper;

    public function __construct(PatientRepository $repository, EntityManagerInterface $manager, PatientMapper $mapper)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->patientMapper = $mapper;
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
}
