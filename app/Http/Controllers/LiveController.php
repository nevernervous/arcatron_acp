<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\DeviceStatus;

class LiveController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->live_access)
                return redirect('/profile');

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLive()
    {
        return view('live.index');
    }

    public function getDeviceStatuses(Request $request) {
        $limit = $request->query('limit');
        if(!$limit)
            $limit = 10;

        $statuses = DeviceStatus::with('customer')->where('ack', '!=', true)->orderBy('id', 'desc')->limit($limit)->get();
        return response()->json([
            'status' => 'success',
            'data' => $statuses
        ]);
    }

    public function ack(Request $request) {
        $id = $request->query('id');

        try {
            $status = DeviceStatus::find($id);
            $status->ack = true;
            $status->save();
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'fail'
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
