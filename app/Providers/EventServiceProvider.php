<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\Server\LoginAttemptEvent::class => [
            \App\Listeners\Server\LoginAttemptListener::class,
        ]
    ];

    public function boot()
    {
        //
    }
}