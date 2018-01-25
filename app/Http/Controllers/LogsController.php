<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function showLogs(Request $request) {
        return view('logs.index');
    }
}
