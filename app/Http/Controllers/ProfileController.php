<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    public function showProfile(Request $request) {
        return view('profile.index');
    }

    public function postUpdateProfile(Request $request) {
        $email = $request->get('email');
        $user = Auth::user();

        if($user->email != $email) {
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Email already exists.'
                ]);
            } else {
                $user->email = $email;
                $user->save();
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully updated.'
        ]);
    }

    public function postChangePassword(Request $request) {
        $oldPwd = $request->get('old_password');

        $user = Auth::user();

        if (Hash::check($oldPwd, $user->getAuthPassword())) {
            $user->password = Hash::make($request->get('password'));
            $user->save();
        } else {
            return response()->json([
                'status'  => 'fail',
                'swal'    => true,
                'message' => 'Password is not correct.'
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully changed.',
        ]);
    }
}
