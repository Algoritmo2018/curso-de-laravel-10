<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\EditUserDTO;
use App\DTO\Users\EditUserProfileDTO;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserProfileRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view user api'], ['only' => ['index','show']]);
        $this->middleware(['permission:create user api'], ['only' => ['store']]);
        $this->middleware(['permission:edit user api'], ['only' => ['update']]);
        $this->middleware(['permission:edit userProfile api'], ['only' => ['updateUserProfile']]);
        $this->middleware(['permission:delete user api'], ['only' => ['destroy']]);}
  
    public function updateUserProfile(UpdateUserProfileRequest $request, string $id)
    {
        if (!$user = User::find($id)) {
            return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
        }
        $user->syncRoles($request->roles);
      
        return response()->json(['success'=>true,'data'=>$user,'message' => 'Perfil do usuario editado com sucesso.']);
    }
 
}
