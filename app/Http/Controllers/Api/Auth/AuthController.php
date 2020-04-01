<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\AuthRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request){


$user = User::where('email', $request->email)->first();
if(!$user || !Hash::check($request->password, $user->password))
{
throw ValidationException::withMessages(
    [
        'email' => ['The provided credebtials are incorrect']
    ]);
}

// Logout others devices
//if($request->has('Logout_others_devices'))
$user->tokens()->delete();

 $token = $user->createToken($request->device_name)->plainTextToken;

 return response()->json([
    'token' => $token,
 ]);

    }

    public function logout(Request $request){


        $request->user()->tokens()->delete();


         return response()->json([
            'message' => 'success',
         ]);

            }

            public function me(Request $request){


               $user = $request->user();


                 return response()->json([
                    'me' => $user,
                 ]);

                    }
}
