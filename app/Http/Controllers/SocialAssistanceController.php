<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreSocialAssistanceRequest;
use App\Http\Requests\UpdateSocialAssistanceRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use Exception;

class SocialAssistanceController extends Controller
{
    private SocialAssistanceRepositoryInterface $socialAssistanceRepository;

    public function __construct(SocialAssistanceRepositoryInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $socialAssistances = $this->socialAssistanceRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Bantuan Sosial berhasil didapatkan', SocialAssistanceResource::collection($socialAssistances), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialAssistanceRequest $request)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Bantuan Sosial berhasil dibuat', SocialAssistanceResource::make($socialAssistance), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialAssistance $social_assistance)
    {
        try {
            $social_assistance->load([
                'recipients.socialAssistance',
                'recipients.family.user',
            ]);

            return ResponseHelper::JsonResponse(true, 'Detail Bantuan Sosial berhasil didapatkan', SocialAssistanceResource::make($social_assistance), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialAssistanceRequest $request, SocialAssistance $social_assistance)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->update($social_assistance, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Bantuan Sosial berhasil diperbarui', SocialAssistanceResource::make($socialAssistance), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialAssistance $social_assistance)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->delete($social_assistance);

            return ResponseHelper::JsonResponse(true, 'Bantuan Sosial berhasil dihapus', SocialAssistanceResource::make($socialAssistance), 200);
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
            $socialAssistances = $this->socialAssistanceRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Bantuan Sosial berhasil didapatkan', PaginateResource::make($socialAssistances, SocialAssistanceResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
