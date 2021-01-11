<?php

namespace App\Mapper;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use Doctrine\Common\Collections\ArrayCollection;

class PatientMapper
{
    public function transformePatientDtoToPatientEntity(PatientDTO $patientDto, Patient $patient)
    {
        $patient->setNom($patientDto->getNom());
        $patient->setPrenom($patientDto->getPrenom());
        $patient->setNumeroTel($patientDto->getNumeroTel());
        $patient->setAdresse($patientDto->getAdresse());
        $patient->setEmail($patientDto->getEmail());
        $patient->setPassword($patientDto->getPassword());
        $patient->setRoles($patientDto->getRoles());
        return $patient;
    }

    public function transformePatientEntityToPatientDto(Patient $patient)
    {
        $patientDto = new PatientDTO();
        $patientDto->setId($patient->getId());
        $patientDto->setNom($patient->getNom());
        $patientDto->setPrenom($patient->getPrenom());
        $patientDto->setNumeroTel($patient->getNumeroTel());
        $patientDto->setAdresse($patient->getAdresse());
        $patientDto->setEmail($patient->getEmail());
        $patientDto->setPassword($patient->getPassword());

        $medecins = $patient->getMedecins();
        $medecinDtos = new ArrayCollection();
        $medecinMapper = new MedecinMapper();
        foreach ($medecins as $medecin) {
            $medecinDtos[] = $medecinMapper->transformeMedecinEntityToMedecinDtoWithoutCollection($medecin);
        }
        $patientDto->setMedecins($medecinDtos);
        return $patientDto;
    }

    public function transformePatientEntityToPatientDtoWithoutCollection(Patient $patient)
    {
        $patientDto = new PatientDTO();
        $patientDto->setId($patient->getId());
        $patientDto->setNom($patient->getNom());
        $patientDto->setPrenom($patient->getPrenom());
        $patientDto->setNumeroTel($patient->getNumeroTel());
        $patientDto->setAdresse($patient->getAdresse());
        $patientDto->setEmail($patient->getEmail());
        $patientDto->setPassword($patient->getPassword());
        return $patientDto;
    }
}
