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
        $data = [
            'statuses' => [],
            'cf' => '',
            'dn' => '',
            'dtn' => '',
            'cl' => '',
            'as' => '',
        ];
        return view('search.index', $data);
    }

    public function postSearch(Request $request) {
        $statuses = DeviceStatus::orderBy('id', 'desc');

        if ($request->has('dn')) {
            $statuses = $statuses->where('device_name', 'like', '%'.$request->get('dn').'%');
        }

        if ($request->has('dtn')) {
            $statuses = $statuses->where('department_name', 'like', '%'.$request->get('dt').'%');
        }

        if ($request->has('cl')) {
            $statuses = $statuses->where('critical_level', '=', $request->get('cl'));
        }

        if ($request->has('as')) {
            $statuses = $statuses->where('alarm_state', '=', $request->get('as'));
        }

//        if ($request->has('cf')) {
//            $statuses = $statuses->where('customer_id', '=', $request->get('as'));
//        }

        $statuses = $statuses->get();

        $data = [
            'statuses' => $statuses,
            'cf' => $request->input('cf'),
            'dn' => $request->input('dn'),
            'dtn' => $request->input('dtn'),
            'cl' => $request->input('cl'),
            'as' => $request->input('as'),
        ];
        return view('search.index', $data);
    }
}
