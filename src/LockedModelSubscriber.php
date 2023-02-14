<?php

namespace Sfolador\Locked;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationSending;
use Sfolador\Locked\Exceptions\LockedModelException;

class LockedModelSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {
        return [
            'eloquent.saving: *' => 'saving',
            'eloquent.deleting: *' => 'deleting',
            'eloquent.replicating: *' => 'replicating',
            NotificationSending::class => 'notificationSending',
        ];
    }

    private function getModelFromPassedParams($params)
    {
        $model = null;
        if (is_array($params) && count($params) > 0) {
            $model = $params[0];
        }

        return $model;
    }

    public function saving(string $event, $entity): bool
    {
        if (app(Locked::class)->allowsModificationsOnLockedObjects()) {
            return true;
        }

        $model = $this->getModelFromPassedParams($entity);

        if (app('locked')->doesNotUseHasLocks($model)) {
            return true;
        }

        $lockedColumnName = app('locked')->getLockedColumnName();

        if ($model->wasUnlocked() && $model->isDirty($lockedColumnName)) {
            //we are locking a model
            return true;
        }

        if ($model->wasLocked() && $model->isDirty()) {
            throw new LockedModelException('This model is locked');
        }

        return true;
    }

    public function deleting(string $event, $entity): bool
    {
        if (app(Locked::class)->allowsModificationsOnLockedObjects()) {
            return true;
        }
        $model = $this->getModelFromPassedParams($entity);
        if (app('locked')->doesNotUseHasLocks($model)) {
            return true;
        }
        if ($model->wasUnlocked()) {
            return true;
        }

        throw new LockedModelException('This model is locked');
    }

    public function replicating(string $event, $entity): bool
    {
        if (app(Locked::class)->allowsModificationsOnLockedObjects()) {
            return true;
        }
        $model = $this->getModelFromPassedParams($entity);
        if (app('locked')->doesNotUseHasLocks($model)) {
            return true;
        }
        if ($model->isUnlocked()) {
            return true;
        }

        throw new LockedModelException('This model is locked');
    }

    public function notificationSending(NotificationSending $event)
    {
        if (app(Locked::class)->allowsNotificationsToLockedObjects()) {
            return false;
        }
        $model = $event->notifiable;
        if (app('locked')->doesNotUseHasLocks($model)) {
            return true;
        }
        if ($model->isUnlocked()) {
            return true;
        }

        throw new LockedModelException('This model is locked');
    }
}
