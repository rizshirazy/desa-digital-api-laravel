<?php

namespace App\Interfaces;

interface FamilyMemberRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);

    public function update($familyMember, array $data);

    public function delete($familyMember);
}
