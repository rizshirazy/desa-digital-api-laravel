<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreHeadOfFamilyRequest;
use App\Http\Requests\UpdateHeadOfFamilyRequest;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;
use App\Models\HeadOfFamily;
use App\Repositories\HeadOfFamilyRepository;
use Exception;

class HeadOfFamilyController extends Controller
{
    private HeadOfFamilyRepository $headOfFamilyRepository;

    public function __construct(HeadOfFamilyRepository $headOfFamilyRepository)
    {
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Kepala Keluarga berhasil didapatkan', HeadOfFamilyResource::collection($headOfFamily), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHeadOfFamilyRequest $request)
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Kepala Keluarga berhasil dibuat', HeadOfFamilyResource::make($headOfFamily), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HeadOfFamily $head_of_family)
    {
        try {
            $head_of_family->load('familyMembers');

            return ResponseHelper::JsonResponse(true, 'Detail Kepala Keluarga berhasil didapatkan', HeadOfFamilyResource::make($head_of_family), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeadOfFamilyRequest $request, HeadOfFamily $head_of_family)
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->update($head_of_family, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Kepala Keluarga berhasil diperbarui', HeadOfFamilyResource::make($headOfFamily), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeadOfFamily $head_of_family)
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->delete($head_of_family);

            return ResponseHelper::JsonResponse(true, 'Kepala Keluarga berhasil dihapus', HeadOfFamilyResource::make($headOfFamily), 200);
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
            $headOfFamily = $this->headOfFamilyRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Kepala Keluarga berhasil didapatkan', PaginateResource::make($headOfFamily, HeadOfFamilyResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
