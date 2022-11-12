<?php

namespace Sfolador\Locked\Traits;

trait HasLocks
{
    public static function getLockedColumnName()
    {
        return config('locked.locking_column');
    }

    public function lock(): self
    {
        $this->{static::getLockedColumnName()} = now();
        $this->save();

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->{static::getLockedColumnName()} !== null;
    }

    public function isNotLocked(): bool
    {
        return ! $this->isLocked();
    }

    public function unlock(): self
    {
        $this->{static::getLockedColumnName()} = null;
        $this->save();

        return $this;
    }

    public function isUnlocked(): bool
    {
        return  ! $this->isLocked();
    }

    public function isNotUnlocked(): bool
    {
        return ! $this->isUnlocked();
    }

    public function toggleLock(): self
    {
        if ($this->isLocked()) {
            $this->unlock();
        } else {
            $this->lock();
        }

        return $this;
    }

    public function scopeLocked($query)
    {
        $query->where(static::getLockedColumnName(), '!=', null);
    }

    public function scopeUnlocked($query)
    {
        $query->where(static::getLockedColumnName(), null);
    }
}
