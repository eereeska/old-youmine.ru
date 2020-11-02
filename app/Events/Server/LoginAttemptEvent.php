<?php

namespace App\Events\Server;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginAttemptEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $ip;

    public function __construct($user, $ip)
    {
        $this->user = $user;
        $this->ip = $ip;
    }
}