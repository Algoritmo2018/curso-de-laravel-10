<?php

namespace App\Repositories;

use App\DTO\Users\UpdateUserProfileDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentORM implements UserRepositoryInterface
{

    public function __construct(
        protected User $model
    ) {}
    public function paginate(int $totalPerPage = 15, string $filter = null, string $guard_name = null)
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', $filter);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($totalPerPage);

        return $result;
    }
    public function findOne(string $id)
    {
        $User = $this->model
            ->find($id);
        if (!$User) {
            return null;
        }
        return $User;
    }

    public function UpdateUserProfile(UpdateUserProfileDTO $dto)
    {
        $dto = (array) $dto;
        if (!$User = $this->model->find($dto['id'])) {
            return null;
        }

        $User->syncRoles($dto['roles']);
        return $User->toArray();
    }
}
