<?php

namespace App\DTO\Users;

use App\Http\Requests\Api\UpdateUserProfileRequest;

class UpdateUserProfileDTO
{
    public function __construct(
        public string $id,
        public array $roles, 
    ) {
    }

    public static function makeFromRequest(UpdateUserProfileRequest $request,string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->roles, 
        );
    }
}
