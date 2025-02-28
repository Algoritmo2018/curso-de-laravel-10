<?php

namespace App\DTO\Roles;

use App\Enums\RoleStatus;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Http\Requests\StoreUpdateRole;

class UpdateRoleDTO
{
    public function __construct(
        public string $id,
        public string $name = "",
        public array $permissions = [],
    ) {}

    public static function makeFromRequest(UpdateRequest $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->name ?? "",
            $request->permissions ?? []
        );
    }
}
