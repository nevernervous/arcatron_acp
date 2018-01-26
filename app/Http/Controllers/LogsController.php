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
        $logs = Logs::with('user')->oldest()->get();
        return view('logs.index', [
            'logs' => $logs
        ]);
    }
}
