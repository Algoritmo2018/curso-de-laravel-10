<?php

namespace App\Repositories\Contracts;

use App\DTO\Users\UpdateUserProfileDTO;

interface UserRepositoryInterface
{ 
    public function paginate( int $totalPerPage = 15, string $filter = null, string $guard_name = null);
    public function UpdateuserProfile(UpdateUserProfileDTO $dto); 
    public function findOne(string $id);

}
