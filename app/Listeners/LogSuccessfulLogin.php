<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Logs;
use Illuminate\Http\Request;

class LogSuccessfulLogin
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $log = new Logs();
        $log->user_id = $user->id;
        $log->action = 'Login';
        $log->description = 'Logged in.';
        $log->ip = $this->request->ip();
        $log->save();
    }
}
