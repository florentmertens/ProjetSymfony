<?php

namespace App\Service;

use App\DTO\MedecinDTO;
use App\DTO\PatientDTO;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\MedecinServiceException;
use App\Mapper\MedecinMapper;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;

class MedecinService
{
    private $medecinRepository;
    private $manager;
    private $medecinMapper;
    private $patientRepository;

    public function __construct(MedecinRepository $medecinRepository, EntityManagerInterface $manager, MedecinMapper $mapper, PatientRepository $patientRepository)
    {
        $this->medecinRepository = $medecinRepository;
        $this->manager = $manager;
        $this->medecinMapper = $mapper;
        $this->patientRepository = $patientRepository;
    }

    public function searchAll()
    {
        try {
            $medecins = $this->medecinRepository->findAll();
            $medecinDtos = [];
            foreach ($medecins as $medecin) {
                $medecinDtos[] = $this->medecinMapper->transformeMedecinEntityToMedecinDto($medecin);
            }
            return $medecinDtos;
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(Medecin $medecin, MedecinDto $medecinDto)
    {
        try {
            $medecin = $this->medecinMapper->transformeMedecinDtoToMedecinEntity($medecinDto, $medecin);
            $this->manager->persist($medecin);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function delete(Medecin $medecin)
    {
        try {
            $this->manager->remove($medecin);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $medecin = $this->medecinRepository->find($id);
            return $this->medecinMapper->transformeMedecinEntityToMedecinDto($medecin);
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchBySpecialite(string $specialite)
    {
        try {
            $medecins = $this->medecinRepository->findBy(["specialite" => $specialite]);
            $medecinDtos = [];
            foreach ($medecins as $medecin) {
                $medecinDtos[] = $this->medecinMapper->transformeMedecinEntityToMedecinDto($medecin);
            }
            return $medecinDtos;
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function addPatient(int $id, MedecinDTO $medecinDto)
    {
        try {
            if ($patient = $this->patientRepository->find($id)) {
                $medecinDto->addPatient($patient);
                $medecin = $this->medecinRepository->find($medecinDto->getId());
                $medecin = $this->medecinMapper->transformeMedecinDtoToMedecinEntity($medecinDto, $medecin);
                $this->manager->persist($medecin);
                $this->manager->flush();
            }
        } catch (DriverException $e) {
            throw new MedecinServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}
