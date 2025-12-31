<?php

namespace App\Repositories;

use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Exception;
use Illuminate\Support\Facades\DB;

class EventParticipantRepository implements EventParticipantRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = EventParticipant::query()
            ->with(['event', 'family.user'])
            ->search($search)
            ->latest()
            ->when($limit, fn ($q) => $q->take($limit));

        return $execute ? $query->get() : $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAll($search, null, false);

        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $participant = new EventParticipant;
            $participant->event_id = $data['event_id'];
            $participant->head_of_family_id = $data['head_of_family_id'];
            $participant->quantity = $data['quantity'];
            $participant->total_price = $this->calculateTotalPrice($data['event_id'], (int) $data['quantity']);
            $participant->payment_status = 'pending';
            $participant->save();
            $participant->refresh();

            DB::commit();

            return $participant->load('event', 'family');
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($participant, array $data)
    {
        DB::beginTransaction();

        try {
            $participant->event_id = $data['event_id'];
            $participant->head_of_family_id = $data['head_of_family_id'];

            if (isset($data['quantity'])) {
                $participant->quantity = $data['quantity'];
                $participant->total_price = $this->calculateTotalPrice($data['event_id'], (int) $data['quantity']);
            }

            if (array_key_exists('payment_status', $data)) {
                $participant->payment_status = $data['payment_status'];
            }

            $participant->save();
            $participant->refresh();

            DB::commit();

            return $participant->load('event', 'family');
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($participant)
    {
        DB::beginTransaction();

        try {
            $participant->delete();

            DB::commit();

            return $participant;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    private function calculateTotalPrice(string $eventId, int $quantity): string
    {
        $pricePerTicket = Event::query()->findOrFail($eventId)->price;

        return number_format((float) $pricePerTicket * $quantity, 2, '.', '');
    }
}
