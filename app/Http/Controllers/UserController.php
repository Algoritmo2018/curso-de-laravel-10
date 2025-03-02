<?php

namespace App\Http\Controllers;

use App\DTO\Users\UpdateUserProfileDTO;
use App\Http\Requests\Api\UpdateUserProfileRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller

{
    public function __construct(protected UserService $user_service, protected RoleService $role_service)
    {
        $this->middleware(['permission:view users'], ['only' => ['index']]);
        //$this->middleware(['permission:create users'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:edit users'], ['only' => ['edit', 'update']]);
        //$this->middleware(['permission:delete users'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::latest()->paginate(1);
        $users =  $this->user_service->paginate(
            totalPerPage: $request->get('per_page', 50),
            filter: $request->filter
        );
        return view('users.list', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $user = $this->user_service->findOne($id);
        $roles = $this->role_service->getAll(
            guard_name: $request->get('guard_name', 'web'),
            filter: $request->filter
        );

        $hasRoles = $user->roles->pluck('id');
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserProfileRequest $request, string $id)
    {
        $user = $this->user_service->UpdateUserProfile(UpdateUserProfileDTO::makeFromRequest($request, $id));
        return redirect()->route('users.index', $id)->with('success', 'User updated successfully.');
    }
}
