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
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *      description="Doctolib Management",
 *      version="V1",
 *      title="Doctolib Management"
 * )
 */
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
     * @OA\Get(
     *     path="/medecins",
     *     tags={"Medecin"},
     *     summary="Returns a list of MedecinDTO",
     *     description="Returns a list of MedecinDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/MedecinDTO")   
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Post(
     *     path="/medecins",
     *     tags={"Medecin"},
     *     summary="Add a MedecinDTO",
     *     description="Add a MedecinDTO",
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation, MedecinDTO create"   
     *     ),
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Put(
     *     path="/medecins/id/{id}",
     *     tags={"Medecin"},
     *     summary="Update a MedecinDTO",
     *     description="Update a MedecinDTO",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of medecin to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation, MedecinDTO update"   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO found"    
     *     ),
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Delete(
     *     path="/medecins/id/{id}",
     *     tags={"Medecin"},
     *     summary="Delete a MedecinDTO",
     *     description="Delete a MedecinDTO",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of medecin to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation, MedecinDTO delete"  
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Get(
     *     path="/medecins/id/{id}",
     *     tags={"Medecin"},
     *     summary="Search a MedecinDTO by ID",
     *     description="Search a MedecinDTO by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of medecin to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/MedecinDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Get(
     *     path="/medecins/{specialite}",
     *     tags={"Medecin"},
     *     summary="Search a MedecinDTO by specialty",
     *     description="Search a MedecinDTO by specialty",
     *      @OA\Parameter(
     *         name="specialite",
     *         in="path",
     *         description="Speciality of medecin to return",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/MedecinDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Post(
     *     path="/medecins/addPatients/{id}",
     *     tags={"Medecin"},
     *     summary="Add Patient to MedecinDTO",
     *     description="Add Patient to MedecinDTO",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation, Patient add to MedecinDTO"   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no MedecinDTO or Patient found"    
     *     ),
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
