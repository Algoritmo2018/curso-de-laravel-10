<?php

namespace App\Repositories;
  
use App\DTO\Roles\CreateRoleDTO;
use App\DTO\Roles\UpdateRoleDTO;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleEloquentORM implements RoleRepositoryInterface
{

    public function __construct(
        protected Role $model
    ) {}

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', 'like', "%{$filter}%");
                }
            })->with('permissions')
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function getAll(string $filter = null): array
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', 'like', "%{$filter}%");
                }
            })->with('permissions')
            ->get()
            ->toArray();
    }
    public function findOne(string $id)
    {
        $role = $this->model->with('user')
            ->find($id);
        if (!$role) {
            return null;
        }
        return (object) $role->toArray();
    }
    public function delete(string $id)
    {
        $role =  $this->model->find($id);
        $role->delete();
    }
    public function new(CreateRoleDTO $dto)
    {
        $dto = (array) $dto;
        $role = $this->model->create(
            $dto
        );

        if (!empty($dto['permissions'])) {
            foreach ($dto['permissions'] as  $id) {
                $role->givePermissionTo($id);
            }
        }

        return  $role;
    }

    public function update(UpdateRoleDTO $dto)
    {
        $dto = (array) $dto;
        if (!$role = $this->model->find($dto['id'])) {
            return null;
        }

        if ($dto['name']) {
            $role->name = $dto['name'];
            $role->save();
        }

        if (!empty($dto['permission'])) {
            $role->syncPermissions($dto['permission']);
        }
        return $role;
    }
}
