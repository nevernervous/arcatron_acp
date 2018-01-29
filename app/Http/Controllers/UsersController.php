<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Log;

class UsersController extends Controller
{
    public function showUsers(Request $request) {
        return view('users.index');
    }

    public function getAllUsers(Request $request) {
        $users = User::with('roles')->get();
        return response()->json([
            'data' => $users
        ]);
    }

    public function postAddUser(Request $request) {

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully created.'
        ]);
    }
}
