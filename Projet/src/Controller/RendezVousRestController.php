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
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      description="Doctolib Management",
 *      version="V1",
 *      title="Doctolib Management"
 * )
 */
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
     * @OA\Post(
     *     path="/rendezVouss",
     *     tags={"RendezVous"},
     *     summary="Add a RendezVousDTO",
     *     description="Add a RendezVousDTO",
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation, RendezVousDTO create"   
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
     * @OA\Put(
     *     path="/rendezVouss/{id}",
     *     tags={"RendezVous"},
     *     summary="Update a RendezVousDTO",
     *     description="Update a RendezVousDTO",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rendezVous to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation, RendezVousDTO update"   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RendezVousDTO found"    
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
     *  @OA\Delete(
     *     path="/rendezVouss/{id}",
     *     tags={"RendezVous"},
     *     summary="Delete a RendezVousDTO",
     *     description="Delete a RendezVousDTO",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rendezVous to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation, RendezVousDTO delete"  
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RendezVousDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Get(
     *     path="/rendezVouss/{id}",
     *     tags={"RendezVous"},
     *     summary="Search a RendezVousDTO by ID",
     *     description="Search a RendezVousDTO by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rendezVous to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RendezVousDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * ) 
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
     * @OA\Get(
     *     path="/rendezVouss/patient/{id}",
     *     tags={"RendezVous"},
     *     summary="Search a RendezVousDTO by Patient ID",
     *     description="Search a RendezVousDTO by Patient ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RendezVousDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
     * @OA\Get(
     *     path="/rendezVouss/medecin/{id}",
     *     tags={"RendezVous"},
     *     summary="Search a RendezVousDTO by Medecin ID",
     *     description="Search a RendezVousDTO by Medecin ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Medecin to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RendezVousDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
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
