<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreEventParticipantRequest;
use App\Http\Requests\UpdateEventParticipantRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\EventParticipant;
use Exception;

class EventParticipantController extends Controller
{
    private EventParticipantRepositoryInterface $participantRepository;

    public function __construct(EventParticipantRepositoryInterface $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', EventParticipant::class);

            $ownedBy = auth()->user()?->hasRole('admin') ? null : auth()->id();
            $participants = $this->participantRepository->getAll(
                request('search'),
                request('limit'),
                true,
                $ownedBy
            );

            return ResponseHelper::JsonResponse(true, 'Data Peserta Event berhasil didapatkan', EventParticipantResource::collection($participants), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventParticipantRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $request->user();

            $this->authorize('create', [EventParticipant::class, $data['head_of_family_id']]);

            if (! $user->hasRole('admin')) {
                $data['head_of_family_id'] = $user->headOfFamily->id;
            }

            $participant = $this->participantRepository->create($data);

            return ResponseHelper::JsonResponse(true, 'Peserta Event berhasil dibuat', EventParticipantResource::make($participant), 201);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventParticipant $event_participant)
    {
        try {
            $this->authorize('view', $event_participant);
            $event_participant->load(['event', 'family.user']);

            return ResponseHelper::JsonResponse(true, 'Detail Peserta Event berhasil didapatkan', EventParticipantResource::make($event_participant), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventParticipantRequest $request, EventParticipant $event_participant)
    {
        try {
            $this->authorize('update', $event_participant);

            $data = $request->validated();

            if (! $request->user()->hasRole('admin')) {
                $data['head_of_family_id'] = $event_participant->head_of_family_id;
            }

            $participant = $this->participantRepository->update($event_participant, $data);

            return ResponseHelper::JsonResponse(true, 'Peserta Event berhasil diperbarui', EventParticipantResource::make($participant), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventParticipant $event_participant)
    {
        try {
            $this->authorize('delete', $event_participant);
            $participant = $this->participantRepository->delete($event_participant);

            return ResponseHelper::JsonResponse(true, 'Peserta Event berhasil dihapus', EventParticipantResource::make($participant), 200);
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
            $this->authorize('viewAny', EventParticipant::class);

            $ownedBy = auth()->user()?->hasRole('admin') ? null : auth()->id();
            $participants = $this->participantRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page'],
                $ownedBy,
            );

            return ResponseHelper::JsonResponse(true, 'Data Peserta Event berhasil didapatkan', PaginateResource::make($participants, EventParticipantResource::class), 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
