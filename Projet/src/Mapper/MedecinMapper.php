<?php

namespace App\Mapper;

use App\DTO\MedecinDTO;
use App\Entity\Medecin;
use Doctrine\Common\Collections\ArrayCollection;

class MedecinMapper
{

    public function transformeMedecinDtoToMedecinEntity(MedecinDTO $medecinDto, Medecin $medecin)
    {
        $medecin->setNom($medecinDto->getNom());
        $medecin->setPrenom($medecinDto->getPrenom());
        $medecin->setNumeroTel($medecinDto->getNumeroTel());
        $medecin->setAdresse($medecinDto->getAdresse());
        $medecin->setEmail($medecinDto->getEmail());
        $medecin->setPassword($medecinDto->getPassword());
        $medecin->setSpecialite($medecinDto->getSpecialite());
        $medecin->setRoles($medecinDto->getRoles());
        $patientDtos = $medecinDto->getPatients();
        foreach ($patientDtos as $patientDto) {
            $medecin->addPatient($patientDto);
        }
        return $medecin;
    }

    public function transformeMedecinEntityToMedecinDto(Medecin $medecin)
    {
        $medecinDto = new MedecinDTO();
        $medecinDto->setId($medecin->getId());
        $medecinDto->setNom($medecin->getNom());
        $medecinDto->setPrenom($medecin->getPrenom());
        $medecinDto->setNumeroTel($medecin->getNumeroTel());
        $medecinDto->setAdresse($medecin->getAdresse());
        $medecinDto->setEmail($medecin->getEmail());
        $medecinDto->setPassword($medecin->getPassword());
        $medecinDto->setSpecialite($medecin->getSpecialite());

        $patients = $medecin->getPatients();
        $patientDtos = new ArrayCollection();
        $patientMapper = new PatientMapper();
        foreach ($patients as $patient) {
            $patientDtos[] = $patientMapper->transformePatientEntityToPatientDtoWithoutCollection($patient);
        }

        $medecinDto->setPatients($patientDtos);
        return $medecinDto;
    }

    public function transformeMedecinEntityToMedecinDtoWithoutCollection(Medecin $medecin)
    {
        $medecinDto = new MedecinDTO();
        $medecinDto->setId($medecin->getId());
        $medecinDto->setNom($medecin->getNom());
        $medecinDto->setPrenom($medecin->getPrenom());
        $medecinDto->setNumeroTel($medecin->getNumeroTel());
        $medecinDto->setAdresse($medecin->getAdresse());
        $medecinDto->setEmail($medecin->getEmail());
        $medecinDto->setPassword($medecin->getPassword());
        $medecinDto->setSpecialite($medecin->getSpecialite());
        return $medecinDto;
    }
}
