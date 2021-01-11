<?php

namespace App\Controller;

use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\RendezVousMapper;
use FOS\RestBundle\View\View;
use App\Service\RendezVousService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\RendezVousServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RendezVousRestController extends AbstractFOSRestController
{
    private $rendezVousService;

    const URI_RENDEZVOUS_COLLECTION = "/rendezVouss";
    const URI_RENDEZVOUS_INSTANCE = "/rendezVouss/{id}";

    public function __construct(RendezVousService $rendezVousService, EntityManagerInterface $entityManager, RendezVousMapper $mapper)
    {
        $this->rendezVousService = $rendezVousService;
        $this->entityManager = $entityManager;
        $this->rendezVousMapper = $mapper;
    }

    /**
     * @Post(RendezVousRestController::URI_RENDEZVOUS_COLLECTION)
     * @ParamConverter("rendezVousDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(RendezVousDTO $rendezVousDto)
    {
        try {
            $this->rendezVousService->persist(new RendezVous(), $rendezVousDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Put(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     * @ParamConverter("rendezVousDto", converter="fos_rest.request_body")
     * @param RendezVousDTO $endezVousDto
     * @return void
     */
    public function update(RendezVous $rendezVous, RendezVousDTO $rendezVousDto)
    {
        try {
            $this->rendezVousService->persist($rendezVous, $rendezVousDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Delete(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function delete(RendezVous $rendezVous)
    {
        try {
            $this->rendezVousService->delete($rendezVous);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     * @return void
     */
    public function searchById(int $id)
    {
        try {
            $rendezVousDto = $this->rendezVousService->searchById($id);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($rendezVousDto) {
            return View::create($rendezVousDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get("/rendezVouss/patient/{id}")
     * @return void
     */
    public function searchByPatientId(int $id)
    {
        try {
            $rendezVoussDto = $this->rendezVousService->searchByPatientId($id);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($rendezVoussDto) {
            return View::create($rendezVoussDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get("/rendezVouss/medecin/{id}")
     * @return void
     */
    public function searchByMedecinId(int $id)
    {
        try {
            $rendezVoussDto = $this->rendezVousService->searchByMedecinId($id);
        } catch (RendezVousServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($rendezVoussDto) {
            return View::create($rendezVoussDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
