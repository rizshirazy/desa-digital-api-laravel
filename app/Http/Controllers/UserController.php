<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(true, 'Data User berhasil didapatkan', UserResource::collection($users), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->validated());

            return ResponseHelper::JsonResponse(true, 'User berhasil dibuat', UserResource::make($user), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = $this->userRepository->getById($id);

            if (! $user) {
                return ResponseHelper::JsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            return ResponseHelper::JsonResponse(true, 'Detail User berhasil didapatkan', UserResource::make($user), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = $this->userRepository->update($id, $request->validated());

            if (! $user) {
                return ResponseHelper::JsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            return ResponseHelper::JsonResponse(true, 'User berhasil diperbarui', UserResource::make($user), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->userRepository->delete($id);

            if (! $user) {
                return ResponseHelper::JsonResponse(false, 'User tidak ditemukan', null, 404);
            }

            return ResponseHelper::JsonResponse(true, 'User berhasil dihapus', UserResource::make($user), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer',
        ]);

        try {
            $users = $this->userRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
            );

            return ResponseHelper::JsonResponse(true, 'Data User berhasil didapatkan', PaginateResource::make($users, UserResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
