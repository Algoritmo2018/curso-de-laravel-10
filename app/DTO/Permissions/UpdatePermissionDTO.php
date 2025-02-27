<?php

namespace App\DTO\Permissions;

use App\Http\Requests\Permission\UpdateRequest;

class UpdatePermissionDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $guard_name,
    ) {}

    public static function makeFromRequest(UpdateRequest $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->name,
            $request->guard_name
        );
    }
}
