<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceStatus;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\LiveStatus;

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
            $customer = Customer::where('name', $status[1])->first();

            if($customer == null) {
                $customer = new Customer();
                $customer->name = $status[1];
                $customer->save();
            }

            $deviceStatus = new DeviceStatus();
            $deviceStatus->device_ip = $status[0];
            $deviceStatus->customer_id = $customer->id;
            $deviceStatus->department_name = $status[2];
            $deviceStatus->device_name = $status[3];
            $deviceStatus->date = Carbon::createFromFormat('m/d/Y H:i:s', $status[4]);
            $deviceStatus->critical_level = substr($status[5], 3);
            $deviceStatus->alarm_state = substr($status[6], 3);
            $deviceStatus->save();

            $liveStatus = LiveStatus::where('customer_id', '=', $customer->id)
                ->where('department_name', '=', $status[2])
                ->where('device_name', '=', $status[3])->first();

            if ($liveStatus == null) {
                $liveStatus = new LiveStatus();
                $liveStatus->device_ip = $status[0];
                $liveStatus->customer_id = $customer->id;
                $liveStatus->department_name = $status[2];
                $liveStatus->device_name = $status[3];
                $liveStatus->date = Carbon::createFromFormat('m/d/Y H:i:s', $status[4]);
                $liveStatus->critical_level = substr($status[5], 3);
                $liveStatus->alarm_state = substr($status[6], 3);
                $liveStatus->last_state = substr($status[6], 3);
            }else {
                $liveStatus->date = Carbon::createFromFormat('m/d/Y H:i:s', $status[4]);
                $liveStatus->critical_level = substr($status[5], 3);
                $liveStatus->last_state = $liveStatus->alarm_state;
                $liveStatus->alarm_state = substr($status[6], 3);
            }

            $liveStatus->save();
        }
        return response()->json(['status' => 'success']);
    }
}