<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = Event::query()
            ->with(['participants'])
            ->search($search)
            ->when($limit, fn ($q) => $q->take($limit))
            ->latest();

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
            $event = new Event;
            $event->name = $data['name'];
            $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            $event->description = $data['description'];
            $event->price = $data['price'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->is_active = $data['is_active'] ?? true;
            $event->save();
            $event->refresh();

            DB::commit();

            return $event;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($event, array $data)
    {
        DB::beginTransaction();

        try {
            $event->name = $data['name'];
            $event->description = $data['description'];
            $event->price = $data['price'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->is_active = $data['is_active'] ?? $event->is_active;

            if (! empty($data['thumbnail'])) {
                $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            }

            $event->save();
            $event->refresh();

            DB::commit();

            return $event;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($event)
    {
        DB::beginTransaction();

        try {
            $event->delete();

            DB::commit();

            return $event;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
