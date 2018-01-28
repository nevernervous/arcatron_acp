<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveStatus extends Model
{
    public $timestamps = false;

    /**
     * The customer associated with device status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(\App\Models\Customer::class);
    }
}
