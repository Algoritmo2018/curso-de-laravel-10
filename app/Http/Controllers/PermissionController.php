<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission; 

class PermissionController extends Controller 
 
{
    public function __construct()
    {
        
        $this->middleware(['permission:view permissions'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create permissions'], ['only' => ['create']]);
        $this->middleware(['permission:edit permissions'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete permissions'], ['only' => ['destroy']]);
    }
   
    // This method will show permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(25);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }
    // This method will edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }
    // This method will update a permission
    public function update($id, Request
    $request)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }
    // This method will delete a permission in DB
    public function destroy(Request $request)
    {
        $id = $request->id;

        $permission = Permission::find($id);

        if ($permission == null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => false
            ]);
        }

        session()->flash('success', 'Permission deleted successfully.');
        $permission->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
