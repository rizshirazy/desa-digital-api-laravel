<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreFamilyMemberRequest;
use App\Http\Requests\UpdateFamilyMemberRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\PaginateResource;
use App\Models\FamilyMember;
use App\Repositories\FamilyMemberRepository;
use Exception;

class FamilyMemberController extends Controller
{
    private FamilyMemberRepository $familyMemberRepository;

    public function __construct(FamilyMemberRepository $familyMemberRepository)
    {
        $this->familyMemberRepository = $familyMemberRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $familyMembers = $this->familyMemberRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Anggota Keluarga berhasil didapatkan', FamilyMemberResource::collection($familyMembers), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyMemberRequest $request)
    {
        try {
            $familyMember = $this->familyMemberRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Anggota Keluarga berhasil ditambahkan', FamilyMemberResource::make($familyMember), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyMember $family_member)
    {
        try {
            $family_member->load('headOfFamily');

            return ResponseHelper::JsonResponse(true, 'Detail Anggota Keluarga berhasil didapatkan', FamilyMemberResource::make($family_member), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyMemberRequest $request, FamilyMember $family_member)
    {
        try {
            $familyMember = $this->familyMemberRepository->update($family_member, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Anggota Keluarga berhasil diperbarui', FamilyMemberResource::make($familyMember), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyMember $family_member)
    {
        try {
            $familyMember = $this->familyMemberRepository->delete($family_member);

            return ResponseHelper::JsonResponse(true, 'Anggota Keluarga berhasil dihapus', FamilyMemberResource::make($familyMember), 200);
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
            $familyMembers = $this->familyMemberRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Anggota Keluarga berhasil didapatkan', PaginateResource::make($familyMembers, FamilyMemberResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
