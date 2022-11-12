<?php

namespace Sfolador\Locked\Traits;

trait Lockable
{
    public function isLocked(): bool
    {
        return $this->locked_at !== null;
    }

    public function lock(): self
    {
        $this->locked_at = now();
        $this->save();

        return $this;
    }

    public function isNotLocked(): bool
    {
        return ! $this->isLocked();
    }
}
