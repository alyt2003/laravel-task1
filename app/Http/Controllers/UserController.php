<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /*public function getAllusers(Request $request){
        return response()->json(User::all());
    }*/
    public function getAllUsers()
    {
        $users = User::with('posts')->get();

        return UserResource::collection($users);
    }
    //
}
