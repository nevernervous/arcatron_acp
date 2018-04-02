<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Logs;
use Hash;
use Image;

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
            }
        }

        $res = array();

        $res['status']  = 'success';
        $res['message'] = 'Successfully updated.';

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatarPath = 'uploads/avatars/';
            $fileName = date('m_d_Y_h_m_s.') . $file->extension();
            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0777, true);
            }
//            $file->move($avatarPath, $fileName);
            Image::make($file)->resize(225, 225)->save(public_path($avatarPath.$fileName));
            $user->avatar = $avatarPath . $fileName;
            $res['reload'] = true;
        }
        $user->save();
        $log = new Logs();
        $log->user_id = $user->id;
        $log->action = 'Profile Edit';
        $log->description = 'Updated profile.';
        $log->ip = $request->ip();
        $log->save();

        return response()->json($res);
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

        $log = new Logs();
        $log->user_id = $user->id;
        $log->action = 'Profile Edit';
        $log->description = 'Changed password.';
        $log->ip = $request->ip();
        $log->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully changed.',
        ]);
    }
}
