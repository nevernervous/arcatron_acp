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
use Illuminate\Support\Facades\Cookie;

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
        $deviceStatuses =
        $liveStatuses = LiveStatus::with('customer');
        $customer_id = Cookie::get('cf');
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $liveStatuses = $liveStatuses->where('customer_id', $customer_id);
        }
        
        $today = DeviceStatus::where('alarm_state', '=', $as)
            ->where(function ($query) use ($customer_id, $user) {
                if (!$user->hasRole('admin')) {
                    $query->where('customer_id', $customer_id);
                }
            })->whereDate('date', DB::raw('CURDATE()'))->count();

        $week = DeviceStatus::where('alarm_state', '=', $as)
            ->where(function ($query) use ($customer_id, $user) {
                if (!$user->hasRole('admin')) {
                    $query->where('customer_id', $customer_id);
                }
            })->whereDate('date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 WEEK)'))->count();

        $month = DeviceStatus::where('alarm_state', '=', $as)
            ->where(function ($query) use ($customer_id, $user) {
                if (!$user->hasRole('admin')) {
                    $query->where('customer_id', $customer_id);
                }
            })->whereDate('date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MONTH)'))->count();

        $ackedList = $user->acks()->pluck('id')->toArray();

        $liveStatuses = $liveStatuses->where('alarm_state', '=', $as)
            ->whereNotIn('id', $ackedList)
            ->orderBy('critical_level', 'asc')
            ->orderBy('date', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'today'  => $today,
            'week'   => $week,
            'month'  => $month,
            'data'   => $liveStatuses,
            'ack'    => $user->ack_access,
        ]);
    }

    public function ack(Request $request) {
        $user = Auth::user();
        if (!$user->ack_access) {
            return response()->json([
                'status' => 'fail',
            ]);
        }

        $id = $request->query('id');
        try {
            $status = LiveStatus::findOrFail($id);
            $user->acks()->attach($id);

            $log = new Logs();
            $log->user_id = $user->id;
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
