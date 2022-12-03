<?php

namespace Sfolador\Locked;

use Illuminate\Database\Eloquent\Model;
use Sfolador\Locked\Traits\HasLocks;

class Locked
{
    public function getLockedColumnName(): string
    {
        return config('locked.locking_column', 'locked_at');
    }

    public function canBeUnlocked($model): bool
    {
        $modelClass = get_class($model);
        $canBeUnlocked = $this->classesThatCanBeUnlocked();
        $unlockAllowed = $this->unlockAllowed();

        return $unlockAllowed || in_array($modelClass, $canBeUnlocked);
    }

    public function cannotBeUnlocked($model): bool
    {
        return ! $this->canBeUnlocked($model);
    }

    public function unlockAllowed(): bool
    {
        return config('locked.unlock_allowed', true);
    }

    public function classesThatCanBeUnlocked(): array
    {
        return config('locked.can_be_unlocked', []);
    }

    public function usesHasLocks(Model $model): bool
    {
        return in_array(HasLocks::class, class_uses($model), true);
    }

    public function doesNotUseHasLocks(Model $model): bool
    {
        return ! $this->usesHasLocks($model);
    }

    public function preventsModificationsOnLockedObjects(): bool
    {
        return config('locked.prevent_modifications_on_locked_objects', false);
    }

    public function allowsModificationsOnLockedObjects(): bool
    {
        return ! $this->preventsModificationsOnLockedObjects();
    }

    public function allowsNotificationsToLockedObjects(): bool
    {
        return config('locked.prevent_notifications_to_locked_objects', false);
    }
}
