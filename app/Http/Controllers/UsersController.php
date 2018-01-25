<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function showUsers(Request $request) {
        return view('users.index');
    }
}
