<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Logs extends Model
{
    protected $table = 'logs';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}
