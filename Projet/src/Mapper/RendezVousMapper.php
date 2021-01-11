<?php

namespace App\Mapper;

use App\DTO\RendezVousDTO;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;

class RendezVousMapper
{
    public function transformeRendezVousDtoToRendezVousEntity(RendezVousDTO $rendezVousDto, RendezVous $rendezVous, Patient $patient, Medecin $medecin)
    {
        $rendezVous->setDate($rendezVousDto->getDate());
        $rendezVous->setHoraire($rendezVousDto->getHoraire());
        $rendezVous->setPatient($patient);
        $rendezVous->setMedecin($medecin);
        return $rendezVous;
    }

    public function transformeRendezVousEntityToRendezVousDto(RendezVous $rendezVous)
    {
        $rendezVousDto = new RendezVousDTO();
        $rendezVousDto->setId($rendezVous->getId());
        $rendezVousDto->setDate($rendezVous->getDate());
        $rendezVousDto->setHoraire($rendezVous->getHoraire());
        $rendezVousDto->setPatientId($rendezVous->getPatient()->getId());
        $rendezVousDto->setMedecinID($rendezVous->getMedecin()->getId());
        return $rendezVousDto;
    }
}
