<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use Exception;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRepository implements SocialAssistanceRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = SocialAssistance::query()
            ->search($search)
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
            $socialAssistance = new SocialAssistance;
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'] ?? true;
            $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social-assistances', 'public');
            $socialAssistance->save();

            DB::commit();

            return $socialAssistance;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($socialAssistance, array $data)
    {
        DB::beginTransaction();

        try {
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'] ?? $socialAssistance->is_available;

            if (! empty($data['thumbnail'])) {
                $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social-assistances', 'public');
            }

            $socialAssistance->save();

            DB::commit();

            return $socialAssistance;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($socialAssistance)
    {
        DB::beginTransaction();

        try {
            $socialAssistance->delete();

            DB::commit();

            return $socialAssistance;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
