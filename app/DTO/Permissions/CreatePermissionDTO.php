<?php

namespace App\DTO\Permissions;
 
use App\Http\Requests\Permission\StoreRequest; 

class CreatePermissionDTO
{
    public function __construct(
        public string $name, 
        public string $guard_name ='',
    ) { }

    public static function makeFromRequest(StoreRequest $request): self
    {
        return new self(
            $request->name, 
            $request->guard_name ?? '' 
        );
    }
}
