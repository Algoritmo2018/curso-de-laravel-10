<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller
{
  
    public function __construct()
    {
        $this->middleware(['permission:view roles api'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create roles api'], ['only' => ['store']]);
        $this->middleware(['permission:edit roles api'], ['only' => ['update']]);
        $this->middleware(['permission:delete roles api'], ['only' => ['destroy']]);
    }
    //This method will show roles page
    public function index()
    {
        $roles = Role::orderBy('id', 'ASC')->with('permissions')->get();
        return RoleResource::collection($roles);
    }

    //This method will insert role in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           // 'name' => 'required|unique:roles|min:3',
            'permission' => 'exists:permissions,id|array',
            'permission.*' => 'integer',
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);
            if (!empty($request->permission)) {
                foreach ($request->permission as  $id) {
                    $role->givePermissionTo($id);
                }
            }
            return response()->json(['success' => true, 'message' => 'Perfil de usuario cadastrado com sucesso', 'data' => $role], 201);
        } else {
            return response()->json(['success' => false, 'error' => "Erros de validação", 'message' => 'Não foi possivel cadastrar o perfil de usuario', 'Errors' => $validator->errors()], 400);
        }
    }
 
    public function update($id, Request $request)
    {
        $role = Role::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'unique:roles,name,' . $id . ',id',
            'permission' => 'exists:permissions,id|array',
            'permission.*' => 'integer',
        ]);

        if ($validator->passes()) {
 
          if($request->name){
            $role->name = $request->name;
            $role->save();
          }
 
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } 

            return response()->json(['success' => true, 'message' => 'Perfil de usuario atualizado com sucesso', 'data' => $role], 200);
      
        } else {
            return response()->json(['success' => false, 'error' => "Erros de validação", 'message' => 'Não foi possivel editar o perfil de usuario', 'Errors' => $validator->errors()], 400);
     
        }
    }
    public function destroy($id)
    {

        $role = Role::findOrFail($id);

        if ($role == null) {
            return response()->json(['success' => false, 'error' => "Perfil de usuario inexistente, id invalido", 'message' => 'A Perfil de usuario não foi deletada com sucesso'], 404);
  
        }
        $role->delete();
        return response()->json(['success' => true, 'message' => 'Permissão deletada com sucesso'], 204);
    }
}
