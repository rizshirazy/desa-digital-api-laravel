<?php

namespace App\Repositories;

use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Models\DevelopmentApplicant;
use Exception;
use Illuminate\Support\Facades\DB;

class DevelopmentApplicantRepository implements DevelopmentApplicantRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute, ?string $ownedBy = null)
    {
        $query = DevelopmentApplicant::query()
            ->with(['development', 'user'])
            ->search($search)
            ->when($ownedBy, fn($q) => $q->where('user_id', $ownedBy))
            ->latest()
            ->when($limit, fn($q) => $q->take($limit));

        return $execute ? $query->get() : $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage, ?string $ownedBy = null)
    {
        $query = $this->getAll($search, null, false, $ownedBy);

        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $applicant = new DevelopmentApplicant;
            $applicant->development_id = $data['development_id'];
            $applicant->user_id = $data['user_id'];
            $applicant->status = $data['status'] ?? 'pending';
            $applicant->save();
            $applicant->refresh();

            DB::commit();

            return $applicant->load(['development', 'user']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($applicant, array $data)
    {
        DB::beginTransaction();

        try {
            $applicant->development_id = $data['development_id'];
            $applicant->user_id = $data['user_id'];

            if (array_key_exists('status', $data)) {
                $applicant->status = $data['status'];
            }

            $applicant->save();
            $applicant->refresh();

            DB::commit();

            return $applicant->load(['development', 'user']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($applicant)
    {
        DB::beginTransaction();

        try {
            $applicant->delete();

            DB::commit();

            return $applicant;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
