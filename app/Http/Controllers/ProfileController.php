<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Interfaces\ProfileRepositoryInterface;
use App\Models\Profile;
use Exception;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        try {
            $this->authorize('viewAny', Profile::class);
            $profile = $this->profileRepository->get();

            if (! $profile) {
                return ResponseHelper::JsonResponse(false, 'Profile tidak ada', null, 404);
            }

            return ResponseHelper::JsonResponse(true, 'Profile berhasil didapatkan', ProfileResource::make($profile), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreProfileRequest $request)
    {
        try {
            $this->authorize('create', Profile::class);
            $profile = $this->profileRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'Profile berhasil dibuat', ProfileResource::make($profile), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $profile = $this->profileRepository->get();

            if (! $profile) {
                return ResponseHelper::JsonResponse(false, 'Profile tidak ada', null, 404);
            }

            $this->authorize('update', $profile);

            $profile = $this->profileRepository->update($request->validated());

            return ResponseHelper::JsonResponse(true, 'Profile berhasil diperbarui', ProfileResource::make($profile), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
