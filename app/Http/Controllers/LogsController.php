<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        return view('logs.index');
    }
}
