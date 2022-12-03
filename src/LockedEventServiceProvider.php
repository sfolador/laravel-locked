<?php

namespace Sfolador\Locked;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Notifications\Events\NotificationSending;

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
