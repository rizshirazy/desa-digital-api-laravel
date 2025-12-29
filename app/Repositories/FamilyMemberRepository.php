<?php

namespace App\Repositories;

use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Models\FamilyMember;
use Exception;
use Illuminate\Support\Facades\DB;

class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = FamilyMember::query()
            ->with(['user', 'headOfFamily.user'])
            ->search($search)
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
            $userRepository = new UserRepository;

            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $familyMember = new FamilyMember;
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->user_id = $user->id;
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->profile_picture = $data['profile_picture']->store('assets/family-members', 'public');
            $familyMember->save();

            DB::commit();

            return $familyMember;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($familyMember, array $data)
    {
        DB::beginTransaction();

        try {
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];

            if (! empty($data['profile_picture'])) {
                $familyMember->profile_picture = $data['profile_picture']->store('assets/family-members', 'public');
            }

            $familyMember->save();

            $userRepository = new UserRepository;
            $userData = [];

            $userData['name'] = $data['name'];
            $userData['email'] = $data['email'];

            if (! empty($data['password'])) {
                $userData['password'] = $data['password'];
            }

            $userRepository->update($familyMember->user, $userData);

            DB::commit();

            return $familyMember;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($familyMember)
    {
        DB::beginTransaction();

        try {
            $familyMember->delete();

            DB::commit();

            return $familyMember;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
