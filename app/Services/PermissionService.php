<?php

namespace App\Services;

use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\UpdatePermissionDTO;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionService
{


    public function __construct(
        protected PermissionRepositoryInterface $repository
    ) {}

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null, string $guard_name = null): PaginationInterface
    {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
            guard_name: $guard_name,
        );
    }
    public function getAll(string $filter = null,string $guard_name = null): array
    {
        return $this->repository->getAll($filter,$guard_name);
    }

    public function findOne(string $id)
    {
        return $this->repository->findOne($id);
    }

    public function new(CreatePermissionDTO $dto)
    {
                return $this->repository->new($dto);
    }

    public function update(UpdatePermissionDTO $dto)
    {
       
        return $this->repository->update($dto);
    }

    public function delete(string $id)
    {
        $this->repository->delete($id);
    }
}
