<?php

namespace App\Http\Controllers;

use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\UpdatePermissionDTO;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller

{
    public function __construct(protected PermissionService $permissionService)
    {

        $this->middleware(['permission:view permissions'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create permissions'], ['only' => ['create']]);
        $this->middleware(['permission:edit permissions'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete permissions'], ['only' => ['destroy']]);
    }

    // This method will show permissions page
    public function index(Request $request)
    {
        $permissions = $this->permissionService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 50),
            filter: $request->filter,
            guard_name: $request->get('guad_name', 'web')
        );
        return view('permissions.list', [
            'permissions' => $permissions
        ]);
    }
    // This method will create permission page
    public function create()
    {
        return view('permissions.create');
    }
    // This method will insert a permission in DB
    public function store(StoreRequest $request)
    {
        $this->permissionService->new(CreatePermissionDTO::makeFromRequest($request));

        return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');
    }
    // This method will edit permission page
    public function edit($id)
    {
        $permission = $this->permissionService->findOne($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }
    // This method will update a permission
    public function update(UpdateRequest $request, string $id)
    {
       $this->permissionService->update(UpdatePermissionDTO::makeFromRequest($request, $id));
       
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }
    // This method will delete a permission in DB
    public function destroy(Request $request)
    {
       
        $permissionDelete = $this->permissionService->delete($request->id);

        session()->flash('success', 'Permission deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
