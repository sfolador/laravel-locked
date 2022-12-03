<?php

namespace Sfolador\Locked\Tests\TestClasses;

use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    // public string $id = 'test-notification';

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'data' => 'Test',
        ];
    }
}
