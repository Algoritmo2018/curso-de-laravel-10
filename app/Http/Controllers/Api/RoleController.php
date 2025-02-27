<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Roles\CreateRoleDTO;
use App\DTO\Roles\UpdateRoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\StoreRequest;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request; 

class RoleController extends Controller
{

    public function __construct(protected RoleService $roleService)
    {
        $this->middleware(['permission:view roles api'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create roles api'], ['only' => ['store']]);
        $this->middleware(['permission:edit roles api'], ['only' => ['update']]);
        $this->middleware(['permission:delete roles api'], ['only' => ['destroy']]);
    }
    //This method will show roles page
    public function index(Request $request)
    {
        $roles = $this->roleService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 50),
            filter: $request->filter,
        );
        return ApiAdapter::toJson($roles);
    }

    //This method will insert role in DB
    public function store(StoreRequest $request)
    {
        $role = $this->roleService->new(CreateRoleDTO::makeFromRequest($request));
        return response()->json(['success' => true, 'message' => 'Perfil de usuario cadastrado com sucesso', 'data' => new RoleResource($role)], 201);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $role = $this->roleService->update(UpdateRoleDTO::makeFromRequest($request, $id));
        return response()->json(['success' => true, 'message' => 'Perfil de usuario atualizado com sucesso', 'data' => $role], 200);
    }
    public function destroy($id)
    {
        $this->roleService->delete($id);
        return response()->json(['success' => true, 'message' => 'Permissão deletada com sucesso'], 204);
    }
}
