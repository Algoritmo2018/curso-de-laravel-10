<?php

namespace App\Repositories\Contracts;

use App\DTO\Permissions\{
    CreatePermissionDTO,
    UpdatePermissionDTO
}; 

interface PermissionRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null, string $guard_name = null): PaginationInterface;
    public function getAll(string $filter = null,string $guard_name = null): array;
    public function findOne(string $id);
    public function delete(string $id);
    public function new(CreatePermissionDTO $dto);
    public function update(UpdatePermissionDTO $dto); 

}
