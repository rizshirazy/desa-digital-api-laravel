<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreSocialAssistanceRecipientRequest;
use App\Http\Requests\UpdateSocialAssistanceRecipientRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecipientResource;
use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecipient;
use Exception;

class SocialAssistanceRecipientController extends Controller
{
    private SocialAssistanceRecipientRepositoryInterface $recipientRepository;

    public function __construct(SocialAssistanceRecipientRepositoryInterface $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $recipients = $this->recipientRepository->getAll(
                request('search'),
                request('limit'),
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan berhasil didapatkan', SocialAssistanceRecipientResource::collection($recipients), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialAssistanceRecipientRequest $request)
    {
        try {
            $recipient = $this->recipientRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Penerima Bantuan berhasil ditambahkan', SocialAssistanceRecipientResource::make($recipient), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialAssistanceRecipient $social_assistance_recipient)
    {
        try {
            $social_assistance_recipient->load(['socialAssistance', 'family.user']);

            return ResponseHelper::JsonResponse(true, 'Detail Penerima Bantuan berhasil didapatkan', SocialAssistanceRecipientResource::make($social_assistance_recipient), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialAssistanceRecipientRequest $request, SocialAssistanceRecipient $social_assistance_recipient)
    {
        try {
            $recipient = $this->recipientRepository->update($social_assistance_recipient, $request->validated());

            return ResponseHelper::JsonResponse(true, 'Penerima Bantuan berhasil diperbarui', SocialAssistanceRecipientResource::make($recipient), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialAssistanceRecipient $social_assistance_recipient)
    {
        try {
            $recipient = $this->recipientRepository->delete($social_assistance_recipient);

            return ResponseHelper::JsonResponse(true, 'Penerima Bantuan berhasil dihapus', SocialAssistanceRecipientResource::make($recipient), 200);
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
            $recipients = $this->recipientRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan berhasil didapatkan', PaginateResource::make($recipients, SocialAssistanceRecipientResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
