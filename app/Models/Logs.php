<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
