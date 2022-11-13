<?php

namespace Sfolador\Locked\Traits;

use Sfolador\Locked\Exceptions\CannotUnlockException;

trait HasLocks
{
    public function lock(): self
    {
        $this->{app('locked')->getLockedColumnName()} = now();
        $this->save();

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->{app('locked')->getLockedColumnName()} !== null;
    }

    public function isNotLocked(): bool
    {
        return ! $this->isLocked();
    }

    public function unlock(): self
    {
        if (app('locked')->cannotBeUnlocked($this)) {
            throw new CannotUnlockException('This model cannot be unlocked');
        }
        $this->{app('locked')->getLockedColumnName()} = null;
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

    public function wasUnlocked()
    {
        return $this->getOriginal(app('locked')->getLockedColumnName()) === null;
    }

    public function wasLocked()
    {
        return $this->getOriginal(app('locked')->getLockedColumnName()) !== null;
    }

    public function scopeLocked($query)
    {
        $query->where(app('locked')->getLockedColumnName(), '!=', null);
    }

    public function scopeUnlocked($query)
    {
        $query->where(app('locked')->getLockedColumnName(), null);
    }
}
