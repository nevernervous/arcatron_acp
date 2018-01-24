<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function deviceStatuses() {
        return $this->hasMany(\App\Models\DeviceStatus::class);
    }
}
