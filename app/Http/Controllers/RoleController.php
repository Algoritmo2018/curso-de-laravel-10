<?php

namespace App\Http\Controllers;

use App\DTO\Roles\CreateRoleDTO;
use App\DTO\Roles\UpdateRoleDTO;
use App\Http\Requests\Api\Role\StoreRequest;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService, protected PermissionService $permissionService)
    {
        $this->middleware(['permission:view roles'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create roles'], ['only' => ['create']]);
        $this->middleware(['permission:edit roles'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete roles'], ['only' => ['destroy']]);
    }
    //This method will show roles page
    public function index(Request $request)
    {
        $roles = $this->roleService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 50),
            filter: $request->filter,
            guard_name: $request->get('guad_name', 'web')
        );

        return view('roles.list', [
            'roles' => $roles
        ]);
    }
    //This method will create role page
    public function create(Request $request)
    {
        $permissions = $this->permissionService->getAll(
            filter: $request->filter,
            guard_name: 'web'
        );

        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }
    //This method will insert role in DB
    public function store(StoreRequest $request)
    {
        $role = $this->roleService->new(CreateRoleDTO::makeFromRequest($request));
        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }

    public function edit($id, Request $request)
    {
        $role = $this->roleService->findOne($id);
        $hasPermissions = $role->permissions;
        $permissions = $this->permissionService->getAll(
            filter: $request->filter,
            guard_name: 'web'
        );

        return view('roles.edit', [
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
            'role' => $role
        ]);
    }

    public function update($id, UpdateRequest $request)
    {    
        $this->roleService->update(UpdateRoleDTO::makeFromRequest($request, $id));
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role =   $this->roleService->delete($id);
        session()->flash('success', 'Role deleted successfully.');

        return response()->json([
            'status' => true
        ]);
    }
}
