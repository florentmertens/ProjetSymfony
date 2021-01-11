<?php

namespace App\Controller;

use App\DTO\MedecinDTO;
use App\Entity\Medecin;
use App\Mapper\MedecinMapper;
use FOS\RestBundle\View\View;
use App\Service\MedecinService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\MedecinServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MedecinRestController extends AbstractFOSRestController
{
    private $medecinService;

    const URI_MEDECIN_COLLECTION = "/medecins";
    const URI_MEDECIN_INSTANCE = "/medecins/id/{id}";

    public function __construct(MedecinService $medecinService, EntityManagerInterface $entityManager, MedecinMapper $mapper)
    {
        $this->medecinService = $medecinService;
        $this->entityManager = $entityManager;
        $this->medecinMapper = $mapper;
    }

    /**
     * @Get(MedecinRestController::URI_MEDECIN_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $medecins =  $this->medecinService->searchAll();
            return View::create($medecins, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Post(MedecinRestController::URI_MEDECIN_COLLECTION)
     * @ParamConverter("medecinDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(MedecinDTO $medecinDto)
    {
        try {
            $this->medecinService->persist(new Medecin(), $medecinDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Put(MedecinRestController::URI_MEDECIN_INSTANCE)
     * @ParamConverter("medecinDto", converter="fos_rest.request_body")
     * @param MedecinDTO $medecinDto
     * @return void
     */
    public function update(Medecin $medecin, MedecinDTO $medecinDto)
    {
        try {
            $this->medecinService->persist($medecin, $medecinDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Delete(MedecinRestController::URI_MEDECIN_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function delete(Medecin $medecin)
    {
        try {
            $this->medecinService->delete($medecin);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(MedecinRestController::URI_MEDECIN_INSTANCE)
     * @return void
     */
    public function searchById(int $id)
    {
        try {
            $medecinDto = $this->medecinService->searchById($id);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($medecinDto) {
            return View::create($medecinDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get("/medecins/{specialite}")
     * @return void
     */
    public function searchBySpecialite(string $specialite)
    {
        try {
            $medecinDtos = $this->medecinService->searchBySpecialite($specialite);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($medecinDtos) {
            return View::create($medecinDtos, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Post("/medecins/addPatient/{id}")
     * @ParamConverter("medecinDto", converter="fos_rest.request_body")
     * @param MedecinDTO $medecinDto
     * @return void
     */
    public function addPatient(int $id, MedecinDTO $medecinDto)
    {
        try {
            $this->medecinService->addPatient($id, $medecinDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (MedecinServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
}
