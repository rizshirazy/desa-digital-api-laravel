<?php

namespace App\Interfaces;

interface EventParticipantRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute, ?string $ownedBy = null);

    public function getAllPaginated(?string $search, ?int $rowPerPage, ?string $ownedBy = null);

    public function create(array $data);

    public function update($participant, array $data);

    public function delete($participant);
}
