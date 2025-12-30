<?php

namespace App\Interfaces;

interface SocialAssistanceRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute);

    public function getAllPaginated(?string $search, ?int $rowPerPage);

    public function create(array $data);

    public function update($socialAssistance, array $data);

    public function delete($socialAssistance);
}
