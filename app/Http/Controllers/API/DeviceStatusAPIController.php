<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceStatus;
use Carbon\Carbon;

class DeviceStatusAPIController extends Controller
{
    public function postDeviceStatus(Request $request) {
        $data = $request->json()->all();
        $deviceStatuses = explode(';', $data['status']);

        foreach($deviceStatuses as $value) {
            if(!$value)
                continue;
            $status = explode('_', $value);
            $deviceStatus = new DeviceStatus();
            $deviceStatus->device_ip = $status[0];
            $deviceStatus->company_name = $status[1];
            $deviceStatus->department_name = $status[2];
            $deviceStatus->device_name = $status[3];
            $deviceStatus->date = Carbon::createFromFormat('M/d/Y H:i:s', $status[4]);
            $deviceStatus->critical_level = substr($status[5], 3);
            $deviceStatus->alarm_state = substr($status[6], 3);
            $deviceStatus->save();
        }
        return response()->json(['status' => 'success']);
    }
}