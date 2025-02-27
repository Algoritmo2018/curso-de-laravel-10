<?php

namespace App\Repositories\Contracts;

use App\DTO\Users\UpdateUserProfileDTO;

interface UserRepositoryInterface
{ 
    public function UpdateuserProfile(UpdateUserProfileDTO $dto); 
    public function findOne(string $id);

}
