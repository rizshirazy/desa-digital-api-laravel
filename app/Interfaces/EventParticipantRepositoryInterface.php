<?php

namespace App\Interfaces;

interface EventParticipantRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);

    public function update($participant, array $data);

    public function delete($participant);
}
