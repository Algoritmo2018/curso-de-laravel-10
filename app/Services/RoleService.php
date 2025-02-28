<?php

namespace App\Services;

use App\DTO\Roles\CreateRoleDTO;
use App\DTO\Roles\UpdateRoleDTO;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $repository
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
    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id)
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateRoleDTO $dto)
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateRoleDTO $dto)
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id)
    {
        $this->repository->delete($id);
    }
}
