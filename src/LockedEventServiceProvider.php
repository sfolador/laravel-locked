<?php

namespace Sfolador\Locked;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class LockedEventServiceProvider extends EventServiceProvider
{
    /**
     * @var string[]
     */
    protected $subscribe = [
        LockedModelSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
