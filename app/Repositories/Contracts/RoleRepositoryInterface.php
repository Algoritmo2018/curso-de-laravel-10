<?php

namespace App\Repositories\Contracts;

use App\DTO\Roles\{
    CreateRoleDTO,
    UpdateRoleDTO
};
use App\Enums\RoleStatus;
use stdClass;

interface RoleRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateRoleDTO $dto): stdClass;
    public function update(UpdateRoleDTO $dto): stdClass|null;
    public function updateStatus(string $id, RoleStatus $status): void;

}
