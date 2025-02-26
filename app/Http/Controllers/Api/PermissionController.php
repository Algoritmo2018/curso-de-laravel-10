<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller

{

    public function __construct()
    {
        $this->middleware(['permission:view permissions api'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create permissions api'], ['only' => ['store']]);
        $this->middleware(['permission:edit permissions api'], ['only' => ['update']]);
        $this->middleware(['permission:delete permissions api'], ['only' => ['destroy']]);
    }
    // This method will show permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->get();
        return PermissionResource::collection($permissions);
    }
    // This method will insert a permission in DB
    public function store(StoreRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);
        return response()->json(['success' => true, 'message' => 'Permissão cadastrada com sucesso', 'data' => $permission], 201);
    }

    // This method will update a permission
    public function update($id, UpdateRequest $request)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['success' => false, 'error' => "Permissão inexistente, id invalido", 'message' => 'A permissão não foi atualizada com sucesso'], 404);
        } else {
            $permission->name = $request->name;
            $permission->save();
            return response()->json(['success' => true, 'message' => 'Permissão atualizada com sucesso', 'data' => $permission], 200);
        }
    }
    // This method will delete a permission in DB
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['success' => false, 'error' => "Permissão inexistente, id invalido", 'message' => 'A permissão não foi deletada com sucesso'], 404);
        } else {
            try {
                $permission->delete();
                return response()->json(['success' => true, 'message' => 'Permissão deletada com sucesso'], 204);
            } catch (\Exception $e) {
                report($e);
                return response()->json(['success' => false, 'error' => $e->getMessage(), 'message' => 'Erro ao deletar permissão'], 500);
            }
        }
    }
}
