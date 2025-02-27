<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\EditUserDTO;
use App\DTO\Users\EditUserProfileDTO;
use App\DTO\Users\UpdateUserProfileDTO;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserProfileRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct(protected UserService $UserService)
    { 
        $this->middleware(['permission:edit userProfile api'], ['only' => ['updateUserProfile']]); 
    }

    public function updateUserProfile(UpdateUserProfileRequest $request, string $id)
    {
        $user = $this->UserService->UpdateUserProfile(UpdateUserProfileDTO::makeFromRequest($request, $id));
          
        return response()->json(['success' => true, 'data' => $user, 'message' => 'Perfil do usuario editado com sucesso.']);
    }
}
