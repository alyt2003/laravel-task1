<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function getAllusers(Request $request){
        return response()->json(User::all());
    }
    //
}
