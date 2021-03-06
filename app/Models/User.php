<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function logs() {
        return $this->hasMany('App\Models\Logs');
    }

    public function customers() {
        return $this->belongsToMany('App\Models\Customer', 'user_customer');
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function acks() {
        return $this->belongsToMany('App\Models\LiveStatus', 'user_ack','user_id', 'live_id');
    }

    public function mutes() {
        return $this->belongsToMany('App\Models\LiveStatus', 'user_mute','user_id', 'live_id');
    }
}
