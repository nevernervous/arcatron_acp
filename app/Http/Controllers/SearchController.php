<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\DeviceStatus;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->logs_access)
                return redirect('/profile');

            return $next($request);
        });
    }

    public function showSearch(Request $request) {
        $statuses = DeviceStatus::where('ack', '!=', true)->orderBy('id', 'desc')->get();;
        $data = [
          'statuses' => $statuses,
        ];
        return view('search.index', $data);
    }
}
