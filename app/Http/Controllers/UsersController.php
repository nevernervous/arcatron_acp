<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Hash;
use Log;
use Auth;
use App\Models\Logs;

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

        $log = new Logs();
        $log->user_id = Auth::user()->id;
        $log->action = 'User Create';
        $log->description = 'Created new user: ' . $username;
        $log->ip = $request->ip();
        $log->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully created.',
            'reload'  => true,
        ]);
    }

    public function postDeleteUser(Request $request) {
        $user = User::find($request->get('id'))->first();
        $username = $user->name;
        $user->delete();

        $log = new Logs();
        $log->user_id = Auth::user()->id;
        $log->action = 'User Delete';
        $log->description = 'Deleted user( ' . $username .').';
        $log->ip = $request->ip();
        $log->save();
        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully deleted.'
        ]);
    }

    public function showEditUser($id) {
        $user = User::find($id);
        $assignedCustomers = $user->customers()->pluck('id')->toArray();
        $customers = Customer::all();
        return view('users.edit', [
            'user' => $user,
            'assignedCustomers' => $assignedCustomers,
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

            if ($request->get('live_page') === 'on')
                $user->live_access = true;
            else
                $user->live_access = false;

            if ($request->get('search_page') === 'on')
                $user->search_access = true;
            else
                $user->search_access = false;

            if ($request->get('ack') === 'on')
                $user->ack_access = true;
            else
                $user->ack_access = false;

            $user->update();
            $message = 'User successfully updated.';

            $log = new Logs();
            $log->user_id = Auth::user()->id;
            $log->action = 'User Update';
            $log->description = 'Updated user(' . $user->name . ').';
            $log->ip = $request->ip();
            $log->save();
        } else {
            $customers = $request->get('customers');
            $user->customers()->sync($customers);
            $user->update();
            $message = 'Successfully assigned.';
            $log = new Logs();
            $log->user_id = Auth::user()->id;
            $log->action = 'Customer Assign';
            $log->description = 'Assigned customers to user(' . $user->name . ').';
            $log->ip = $request->ip();
            $log->save();
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message,
        ]);
    }
}
