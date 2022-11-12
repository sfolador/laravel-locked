<?php

namespace Sfolador\Locked\Traits;

trait HasLocks
{
    public function lock(): self
    {
        $this->locked_at = now();
        $this->save();

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked_at !== null;
    }

    public function isNotLocked(): bool
    {
        return ! $this->isLocked();
    }

    public function unlock(): self
    {
        $this->locked_at = null;
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

    public function scopeLocked($query){
        $query->where('locked_at', '!=', null);
    }

    public function scopeUnlocked($query){
        $query->where('locked_at', null);
    }
}
