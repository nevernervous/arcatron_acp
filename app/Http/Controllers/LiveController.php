<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\LiveStatus;
use App\Models\DeviceStatus;
use App\Models\Logs;

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
//        $limit = $request->query('limit');
//        if(!$limit)
//            $limit = 10;

//        $statuses = LiveStatus::with('customer')->where('ack', '!=', true)->orderBy('id', 'desc')->limit($limit)->get();

        $as = $request->get('as');
        $today = DeviceStatus::where('alarm_state', '=', $as)
            ->whereDate('date', DB::raw('CURDATE()'))->count();
        $week = DeviceStatus::where('alarm_state', '=', $as)
            ->whereDate('date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 WEEK)'))->count();
        $month = DeviceStatus::where('alarm_state', '=', $as)
            ->whereDate('date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MONTH)'))->count();
        $statuses = LiveStatus::with('customer')->where('ack', '!=', true)
            ->where('alarm_state', '=', $as)
            ->orderBy('date', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'today'  => $today,
            'week'   => $week,
            'month'  => $month,
            'data'   => $statuses
        ]);
    }

    public function ack(Request $request) {
        $id = $request->query('id');

        try {
            $status = LiveStatus::find($id);
            $status->ack = true;
            $status->save();

            $log = new Logs();
            $log->user_id = Auth::user()->id;
            $log->action = 'ACK';
            $log->description = 'Acknowledged ' . $status->device_name . '.';
            $log->ip = $request->ip();
            $log->save();
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
