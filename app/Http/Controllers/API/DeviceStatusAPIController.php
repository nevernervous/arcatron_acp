<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceStatus;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\LiveStatus;
use Mockery\Exception;
use Log;

class DeviceStatusAPIController extends Controller
{
    public function postDeviceStatus(Request $request) {
        try{
            $data = $request->json()->all();
            $decryptedStatus = shell_exec("echo ".$data['status']."| openssl enc -aes-128-cbc -a -d -pass pass:". env('SECRET_KEY'));
            $decryptedStatus = str_replace("\n", "", $decryptedStatus);
            $deviceStatuses = explode(';', $decryptedStatus);

            foreach($deviceStatuses as $value) {
                if(!$value)
                    continue;
                $status = explode('_', $value);
                $customer = Customer::where('name', $status[1])->first();
                Log::info($status);
                if($customer == null) {
                    $customer = new Customer();
                    $customer->name = $status[1];
                    $customer->save();
                }

                $date = Carbon::createFromFormat('m/d/Y H:i:s', $status[4]);
                $deviceStatus = new DeviceStatus();
                $deviceStatus->device_ip = $status[0];
                $deviceStatus->customer_id = $customer->id;
                $deviceStatus->department_name = $status[2];
                $deviceStatus->device_name = $status[3];
                $deviceStatus->date = $date;
                $deviceStatus->critical_level = substr($status[5], 3);
                $deviceStatus->alarm_state = substr($status[6], 3);
                $deviceStatus->save();

                $liveStatus = LiveStatus::where('customer_id', '=', $customer->id)
                    ->where('department_name', '=', $status[2])
                    ->where('device_name', '=', $status[3])->first();

                if ($liveStatus == null) {
                    Log::info('new created');
                    $liveStatus = new LiveStatus();
                    $liveStatus->device_ip = $deviceStatus->device_ip;
                    $liveStatus->customer_id = $deviceStatus->customer_id;
                    $liveStatus->department_name = $deviceStatus->department_name;
                    $liveStatus->device_name = $deviceStatus->device_name;
                    $liveStatus->date = $date;
                    $liveStatus->last_state_date = $date;
                    $liveStatus->critical_level = $deviceStatus->critical_level;
                    $liveStatus->alarm_state = $deviceStatus->alarm_state;
                    $liveStatus->last_state = $deviceStatus->alarm_state;
                }else {
                    $last_state_date = Carbon::createFromFormat('d/m/Y H:i:s', $liveStatus->date);
                    if ($date->gt($last_state_date)) {
                        Log::info('updated');
                        $liveStatus->last_state_date = $last_state_date;
                        $liveStatus->date = $date;
                        $liveStatus->critical_level = $deviceStatus->critical_level;
                        $liveStatus->last_state = $liveStatus->alarm_state;
                        $liveStatus->alarm_state = $deviceStatus->alarm_state;
                    }
                }

                $liveStatus->save();
            }
        } catch(Exception $e) {
            Log::error($e);
            return response()->json(['status' => 'fail'], 500);
        }

        return response()->json(['status' => 'success']);
    }
}