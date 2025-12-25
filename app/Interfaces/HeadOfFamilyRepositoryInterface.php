<?php

namespace App\Interfaces;

interface HeadOfFamilyRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute);

    public function getAllPaginated(?string $search, ?int $row_per_page);

    public function create(array $data);

    public function update($headOfFamily, array $data);

    public function delete($headOfFamily);
}
