<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LiveStatus extends Model
{

    /**
     * The customer associated with device status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(\App\Models\Customer::class);
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getLastStateDateAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User', 'user_ack', 'live_id', 'user_id');
    }
}
