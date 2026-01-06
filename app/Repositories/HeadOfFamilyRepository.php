<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Exception;
use Illuminate\Support\Facades\DB;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute, ?string $ownedBy = null)
    {
        $query = HeadOfFamily::query()
            ->search($search)
            ->when($ownedBy, fn($q) => $q->where('user_id', $ownedBy))
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
            $userRepository = new UserRepository;

            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->assignRole('head-of-family');

            $headOfFamily = new HeadOfFamily;
            $headOfFamily->user_id = $user->id;
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-families', 'public');
            $headOfFamily->save();

            DB::commit();

            return $headOfFamily;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update($headOfFamily, array $data)
    {
        DB::beginTransaction();

        try {
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];

            if (! empty($data['profile_picture'])) {
                $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-families', 'public');
            }

            $headOfFamily->save();

            $userRepository = new UserRepository;
            $userData = [];

            $userData['name'] = $data['name'];
            $userData['email'] = $data['email'];

            if (! empty($data['password'])) {
                $userData['password'] = $data['password'];
            }

            $userRepository->update($headOfFamily->user, $userData);

            DB::commit();

            return $headOfFamily;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete($headOfFamily)
    {
        DB::beginTransaction();

        try {
            $headOfFamily->delete();

            DB::commit();

            return $headOfFamily;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
