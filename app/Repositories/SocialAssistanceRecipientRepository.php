<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecipient;
use Exception;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRecipientRepository implements SocialAssistanceRecipientRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute, ?string $ownedBy = null)
    {
        $query = SocialAssistanceRecipient::query()
            ->with(['socialAssistance', 'family.user'])
            ->search($search)
            ->when($ownedBy, fn($q) => $q->whereHas('family', fn($fq) => $fq->where('user_id', $ownedBy)))
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
            $recipient = new SocialAssistanceRecipient;
            $recipient->social_assistance_id = $data['social_assistance_id'];
            $recipient->head_of_family_id = $data['head_of_family_id'];
            $recipient->amount = $data['amount'];
            $recipient->reason = $data['reason'];
            $recipient->bank = $data['bank'];
            $recipient->account_number = $data['account_number'];

            if (array_key_exists('status', $data)) {
                $recipient->status = $data['status'];
            }

            if (! empty($data['proof'])) {
                $recipient->proof = $data['proof']->store('assets/social-assistance-recipients', 'public');
            }
            $recipient->save();
            $recipient->refresh();

            DB::commit();

            return $recipient;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($recipient, array $data)
    {
        DB::beginTransaction();

        try {
            $recipient->social_assistance_id = $data['social_assistance_id'];
            $recipient->head_of_family_id = $data['head_of_family_id'];
            $recipient->amount = $data['amount'];
            $recipient->reason = $data['reason'];
            $recipient->bank = $data['bank'];
            $recipient->account_number = $data['account_number'];

            if (! empty($data['proof'])) {
                $recipient->proof = $data['proof']->store('assets/social-assistance-recipients', 'public');
            }

            if (array_key_exists('status', $data)) {
                $recipient->status = $data['status'];
            }

            $recipient->save();
            $recipient->refresh();

            DB::commit();

            return $recipient;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($recipient)
    {
        DB::beginTransaction();

        try {
            $recipient->delete();

            DB::commit();

            return $recipient;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
