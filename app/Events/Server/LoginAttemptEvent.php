<?php

namespace App\Events\Server;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginAttemptEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $name;
    public $ip;

    public function __construct($user, $name, $ip)
    {
        $this->user = $user;
        $this->name = $name;
        $this->ip = $ip;
    }
}