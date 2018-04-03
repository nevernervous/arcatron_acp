<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Logs;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->logs_access)
                return redirect('/profile');

            return $next($request);
        });
    }

    public function showLogs(Request $request) {
        $user = Auth::user();
        if($user->hasRole('admin'))
            $logs = Logs::with('user')->latest()->get();
        else
            $logs = Logs::with('user')->where('user_id', '=', $user->id)->latest()->get();

        return view('logs.index', [
            'logs' => $logs
        ]);
    }
}
