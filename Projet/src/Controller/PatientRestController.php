<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\PatientServiceException;
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
class PatientRestController extends AbstractFOSRestController
{
    private $patientService;

    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE = "/patients/{id}";

    public function __construct(PatientService $patientService, EntityManagerInterface $entityManager, PatientMapper $mapper)
    {
        $this->patientService = $patientService;
        $this->entityManager = $entityManager;
        $this->patientMapper = $mapper;
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     tags={"Patient"},
     *     summary="Add a PatientDTO",
     *     description="Add a PatientDTO",
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation, PatientDTO create"   
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
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(PatientDTO $patientDto)
    {
        try {
            $this->patientService->persist(new Patient(), $patientDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     tags={"Patient"},
     *     summary="Update a PatientDTO",
     *     description="Update a PatientDTO",
     *     @OA\Parameter(
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
     *         response=200,
     *         description="Successful operation, PatientDTO update"   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no PatientDTO found"    
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
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     * @param PatientDTO $patientDto
     * @return void
     */
    public function update(Patient $patient, PatientDTO $patientDto)
    {
        try {
            $this->patientService->persist($patient, $patientDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/patients/{id}",
     *     tags={"Patient"},
     *     summary="Delete a PatientDTO",
     *     description="Delete a PatientDTO",
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
     *         response=204,
     *         description="Successful operation, PatientDTO delete"  
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no PatientDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * )
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function delete(Patient $patient)
    {
        try {
            $this->patientService->delete($patient);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *     path="/Patients/{id}",
     *     tags={"Patient"},
     *     summary="Search a PatientDTO by ID",
     *     description="Search a PatientDTO by ID",
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
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")   
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no PatientDTO found"    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us"    
     *     )
     * ) 
     * @Get(PatientRestController::URI_PATIENT_INSTANCE)
     * @return void
     */
    public function searchById(int $id)
    {
        try {
            $patientDto = $this->patientService->searchById($id);
        } catch (PatientServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if ($patientDto) {
            return View::create($patientDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
