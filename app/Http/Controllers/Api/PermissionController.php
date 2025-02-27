<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\UpdatePermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller

{

    public function __construct(protected PermissionService $permissionService)
    {
        $this->middleware(['permission:view permissions api'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create permissions api'], ['only' => ['store']]);
        $this->middleware(['permission:edit permissions api'], ['only' => ['update']]);
        $this->middleware(['permission:delete permissions api'], ['only' => ['destroy']]);
    }
    // This method will show permissions page
    public function index(Request $request)
    {
        $permissions = $this->permissionService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 50),
            filter: $request->filter,
        );
        return ApiAdapter::toJson($permissions);
    }
    // This method will insert a permission in DB
    public function store(StoreRequest $request)
    {
        $permission =  $this->permissionService->new(CreatePermissionDTO::makeFromRequest($request));

        return response()->json(['success' => true, 'message' => 'Permissão cadastrada com sucesso', 'data' => new PermissionResource($permission)], 201);
    }

    // This method will update a permission
    public function update(UpdateRequest $request, string $id)
    {
        $permission = $this->permissionService->update(UpdatePermissionDTO::makeFromRequest($request, $id));
        if (!$permission) {
            return response()->json(['success' => false, 'error' => 'Id invalido', 'message' => 'Não foi possivel  atualizar a permissão', 'data' => $permission], 200);
        }
        return response()->json(['success' => true, 'message' => 'Permissão atualizada com sucesso', 'data' => new PermissionResource($permission)], 200);
    }
    // This method will delete a permission in DB
    public function destroy($id)
    {
        $this->permissionService->delete($id);
        return response()->json(['success' => true, 'message' => 'Permissão deletada com sucesso'], 204);
    }
}
