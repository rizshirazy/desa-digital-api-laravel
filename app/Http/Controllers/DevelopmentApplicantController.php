<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreDevelopmentApplicantRequest;
use App\Http\Requests\UpdateDevelopmentApplicantRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Models\DevelopmentApplicant;
use Exception;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $applicants = $this->developmentApplicantRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Pendaftar Pembangunan berhasil didapatkan', DevelopmentApplicantResource::collection($applicants), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDevelopmentApplicantRequest $request)
    {
        try {
            $applicant = $this->developmentApplicantRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Pendaftar Pembangunan berhasil dibuat', DevelopmentApplicantResource::make($applicant), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DevelopmentApplicant $development_applicant)
    {
        try {
            $development_applicant->load(['development', 'user']);

            return ResponseHelper::JsonResponse(true, 'Detail Pendaftar Pembangunan berhasil didapatkan', DevelopmentApplicantResource::make($development_applicant), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDevelopmentApplicantRequest $request, DevelopmentApplicant $development_applicant)
    {
        try {
            $applicant = $this->developmentApplicantRepository->update($development_applicant, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Pendaftar Pembangunan berhasil diperbarui', DevelopmentApplicantResource::make($applicant), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DevelopmentApplicant $development_applicant)
    {
        try {
            $applicant = $this->developmentApplicantRepository->delete($development_applicant);

            return ResponseHelper::JsonResponse(true, 'Pendaftar Pembangunan berhasil dihapus', DevelopmentApplicantResource::make($applicant), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated()
    {
        $validated = request()->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer',
        ]);

        try {
            $applicants = $this->developmentApplicantRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Pendaftar Pembangunan berhasil didapatkan', PaginateResource::make($applicants, DevelopmentApplicantResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
