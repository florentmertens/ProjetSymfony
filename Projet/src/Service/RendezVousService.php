<?php

namespace App\Service;

use App\DTO\RendezVousDTO;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\RendezVousServiceException;
use App\Mapper\RendezVousMapper;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;

class RendezVousService
{
    private $repository;
    private $manager;
    private $rendezVousMapper;
    private $patientRepository;
    private $medecinRepository;

    public function __construct(RendezVousRepository $repository, EntityManagerInterface $manager, RendezVousMapper $mapper, PatientRepository $patientRepository, MedecinRepository $medecinRepository)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->rendezVousMapper = $mapper;
        $this->patientRepository = $patientRepository;
        $this->medecinRepository = $medecinRepository;
    }

    public function searchAll()
    {
        try {
            $rendezVouss = $this->repository->findAll();
            $rendezVousDtos = [];
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDtos[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
            }
            return $rendezVousDtos;
        } catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(RendezVous $rendezVous, RendezVousDto $rendezVousDto)
    {
        try {
            $patient = $this->patientRepository->find($rendezVousDto->getPatientId());
            $medecin = $this->medecinRepository->find($rendezVousDto->getMedecinId());
            $rendezVous = $this->rendezVousMapper->transformeRendezVousDtoToRendezVousEntity($rendezVousDto, $rendezVous, $patient, $medecin);
            $this->manager->persist($rendezVous);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new RendezVousServiceException($e->getMessage(), $e->getCode());
        }
    }

    public function delete(RendezVous $rendezVous)
    {
        try {
            $this->manager->remove($rendezVous);
            $this->manager->flush();
        } catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $rendezVous = $this->repository->find($id);
            return $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
        } catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchByPatientId(int $id)
    {
        try {
            $rendezVouss = $this->repository->findBy(["patient" => $id]);
            $rendezVousDtos = [];
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDtos[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
            }
            return $rendezVousDtos;
        } catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchByMedecinId(int $id)
    {
        try {
            $rendezVouss = $this->repository->findBy(["medecin" => $id]);
            $rendezVousDtos = [];
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDtos[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
            }
            return $rendezVousDtos;
        } catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}
