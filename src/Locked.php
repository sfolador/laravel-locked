<?php

namespace Sfolador\Locked;

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
}
