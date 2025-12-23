<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = User::query()
            ->search($search)
            ->when($limit, fn ($q) => $q->take($limit));

        return $execute ? $query->get() : $query;
    }

    public function getAllPaginated(?string $search, ?string $rowPerPage)
    {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }

    public function getById(string $id)
    {
        return User::where('id', $id)->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);

            if (! $user) {
                DB::rollBack();

                return null;
            }

            $user->name = $data['name'];

            if (isset($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $user->save();

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);

            if (! $user) {
                DB::rollBack();

                return null;
            }

            $user->delete();

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
