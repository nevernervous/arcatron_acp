<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Hash;
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
        $username = $request->get('username');
        $email = $request->get('email');
        $user = User::where('name', '=', $username)
            ->orWhere('email', '=', $email)->first();

        if ($user) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'User already exists.'
            ]);
        }

        $user = new User();
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($request->get('password'));
        $user->live_access = true;
        $user->search_access = true;

        $user_role = $request->get('role');

        if($user_role === 'admin')
            $user->logs_access = true;

        $user->save();

        $role= Role::where('name', $user_role)->first();
        $user->attachRole($role);

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully created.',
            'reload'  => true,
        ]);
    }

    public function postDeleteUser(Request $request) {
        User::find($request->get('id'))->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully deleted.'
        ]);
    }

    public function showEditUser($id) {
        $user = User::find($id);
        $customers = Customer::all();
        return view('users.edit', [
            'user' => $user,
            'customers' => $customers,
        ]);
    }

    public function postUpdateUser(Request $request, $id) {
        $user = User::find($id);

        $type = $request->get('type');

        $message = '';

        if ($type === 'account') {
            $email = $request->get('email');
            if($user->email != $email) {
                if (User::where('email', '=', $email)->exists())
                    return response()->json([
                        'status'  => 'fail',
                        'message' => 'Email already exists.'
                    ]);
                $user->email = $email;
            }

            if ($request->get('logs_page') === 'on')
                $user->logs_access = true;
            else
                $user->logs_access = false;

            $user->save();
            $message = 'User successfully updated.';
        } else {
            $customers = $request->get('customers');
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message,
        ]);
    }
}
