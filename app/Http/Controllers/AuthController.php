<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    public function register(StoreUserRequest $request){
        $user=User::create($request->validated());
        return response()->json($user,201);
    }

    public function login(Request $request){
        $user=User::where('email',$request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
    //
}
