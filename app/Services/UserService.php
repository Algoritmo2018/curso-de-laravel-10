<?php

namespace App\Services;
  
use App\DTO\Users\UpdateUserProfileDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
 

class UserService
{ 
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function findOne(string $id)
    {
        return $this->repository->findOne($id);
    }
  
    public function UpdateUserProfile(UpdateUserProfileDTO $dto)
    {
        return $this->repository->UpdateUserProfile($dto);
    }
 
}
