<?php

namespace App\Listeners\Server;

use App\Models\ServerLoginAttempt;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginAttemptListener implements ShouldQueue
{
    public function handle($event)
    {
        ServerLoginAttempt::create([
            'user_id' => $event->user->id ?? null,
            'ip' => $event->ip
        ]);
    }
}