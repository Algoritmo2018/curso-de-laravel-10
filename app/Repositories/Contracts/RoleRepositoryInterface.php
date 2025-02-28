<?php

namespace App\Repositories\Contracts;

use App\DTO\Roles\{
    CreateRoleDTO,
    UpdateRoleDTO
};

interface RoleRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null, string $guard_name = null): PaginationInterface;
    public function getAll(string $filter = null);
    public function findOne(string $id);
    public function delete(string $id);
    public function new(CreateRoleDTO $dto);
    public function update(UpdateRoleDTO $dto);
}
