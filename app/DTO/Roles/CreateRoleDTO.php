<?php

namespace App\DTO\Roles;
 
use App\Http\Requests\Api\Role\StoreRequest; 

class CreateRoleDTO
{
    public function __construct(
        public string $name, 
        public string $guard_name, 
        public array $permissions = [],
    ) { }

    public static function makeFromRequest(StoreRequest $request): self
    {
        return new self(
            $request->name, 
            $request->guard_name, 
            $request->permissions ?? []
        );
    }
}
