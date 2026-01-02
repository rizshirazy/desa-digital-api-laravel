<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreDevelopmentRequest;
use App\Http\Requests\UpdateDevelopmentRequest;
use App\Http\Resources\DevelopmentResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentRepositoryInterface;
use App\Models\Development;
use Exception;

class DevelopmentController extends Controller
{
    private DevelopmentRepositoryInterface $developmentRepository;

    public function __construct(DevelopmentRepositoryInterface $developmentRepository)
    {
        $this->developmentRepository = $developmentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $developments = $this->developmentRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Pembangunan berhasil didapatkan', DevelopmentResource::collection($developments), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDevelopmentRequest $request)
    {
        try {
            $development = $this->developmentRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Pembangunan berhasil dibuat', DevelopmentResource::make($development), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Development $development)
    {
        try {
            $development->load('applicants.user');

            return ResponseHelper::JsonResponse(true, 'Detail Pembangunan berhasil didapatkan', DevelopmentResource::make($development), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDevelopmentRequest $request, Development $development)
    {
        try {
            $development = $this->developmentRepository->update($development, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Pembangunan berhasil diperbarui', DevelopmentResource::make($development), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Development $development)
    {
        try {
            $development = $this->developmentRepository->delete($development);

            return ResponseHelper::JsonResponse(true, 'Pembangunan berhasil dihapus', DevelopmentResource::make($development), 200);
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
            $developments = $this->developmentRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Pembangunan berhasil didapatkan', PaginateResource::make($developments, DevelopmentResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
