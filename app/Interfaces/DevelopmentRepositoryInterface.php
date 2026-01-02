<?php

namespace App\Interfaces;

interface DevelopmentRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);

    public function update($development, array $data);

    public function delete($development);
}
