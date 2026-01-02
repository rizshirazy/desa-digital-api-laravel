<?php

namespace App\Repositories;

use App\Interfaces\DevelopmentRepositoryInterface;
use App\Models\Development;
use Exception;
use Illuminate\Support\Facades\DB;

class DevelopmentRepository implements DevelopmentRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = Development::query()
            ->search($search)
            ->with('applicants.user')
            ->latest()
            ->when($limit, fn($q) => $q->take($limit));

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
            $development = new Development;
            $development->name = $data['name'];
            $development->thumbnail = $data['thumbnail']->store('assets/developments', 'public');
            $development->description = $data['description'];
            $development->person_in_charge = $data['person_in_charge'];
            $development->start_date = $data['start_date'];
            $development->end_date = $data['end_date'];
            $development->amount = $data['amount'];
            $development->status = $data['status'] ?? 'ongoing';
            $development->save();
            $development->refresh();

            DB::commit();

            return $development;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($development, array $data)
    {
        DB::beginTransaction();

        try {
            $development->name = $data['name'];
            $development->description = $data['description'];
            $development->person_in_charge = $data['person_in_charge'];
            $development->start_date = $data['start_date'];
            $development->end_date = $data['end_date'];
            $development->amount = $data['amount'];

            if (! empty($data['status'])) {
                $development->status = $data['status'];
            }

            if (! empty($data['thumbnail'])) {
                $development->thumbnail = $data['thumbnail']->store('assets/developments', 'public');
            }

            $development->save();
            $development->refresh();

            DB::commit();

            return $development;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($development)
    {
        DB::beginTransaction();

        try {
            $development->delete();

            DB::commit();

            return $development;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
