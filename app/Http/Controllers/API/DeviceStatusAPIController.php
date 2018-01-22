<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceStatus;
use Carbon\Carbon;
use Log;
class DeviceStatusAPIController extends Controller
{
    public function postDeviceStatus(Request $request) {
        $data = $request->json()->all();
        $decryptedStatus = shell_exec("echo ".$data['status']."| openssl enc -aes-128-cbc -a -d -pass pass:". env('SECRET_KEY'));
        $decryptedStatus = str_replace("\n", "", $decryptedStatus);
        $deviceStatuses = explode(';', $decryptedStatus);

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