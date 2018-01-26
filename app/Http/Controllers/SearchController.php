<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        return view('search.index');
    }
}
