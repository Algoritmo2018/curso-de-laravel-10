<?php

namespace App\Repositories;

use stdClass;
use App\Enums\PermissionStatus;
use Illuminate\Permission\Facades\Gate;
use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\UpdatePermissionDTO;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionEloquentORM implements PermissionRepositoryInterface
{

    public function __construct(
        protected Permission $model
    ) {}

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null, string $guard_name = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', $filter);
                }
            })->where(function ($query) use ($guard_name) {
                if ($guard_name) {
                    $query->where('guard_name', $guard_name);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function getAll(string $filter = null, string $guard_name = null): array
    {
         
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', $filter);
                }
            })
            ->where(function ($query) use ($guard_name) {
                if ($guard_name) {
                    $query->where('guard_name', $guard_name);
                }
            })
            ->get()
            ->toArray();
    }
    public function findOne(string $id)
    {
        $permission = $this->model
            ->find($id);
        if (!$permission) {
            return null;
        }
        return  $permission;
    }
    public function delete(string $id)
    {
        $permission =  $this->model->find($id);
        $permission->delete();
        return $permission;
    }
    public function new(CreatePermissionDTO $dto)
    {
        $permission = $this->model->create(
            (array) $dto
        );
        return  $permission;
    }

    public function update(UpdatePermissionDTO $dto)
    {
        if (!$permission = $this->model->find($dto->id)) {
            return null;
        }

        $permission->update(
            (array) $dto
        );

        return  $permission;
    }
}
