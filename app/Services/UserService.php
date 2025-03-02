<?php

namespace App\Services;
  
use App\DTO\Users\UpdateUserProfileDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
 

class UserService
{ 
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function paginate( int $totalPerPage = 15, string $filter = null, string $guard_name = null)
    {
        return $this->repository->paginate(
                  totalPerPage: $totalPerPage,
            filter: $filter,
            guard_name: $guard_name,
        );
    }
    public function findOne(string $id)
    {
        return $this->repository->findOne($id);
    }
  
    public function UpdateUserProfile(UpdateUserProfileDTO $dto)
    {
        return $this->repository->UpdateUserProfile($dto);
    }
 
}
