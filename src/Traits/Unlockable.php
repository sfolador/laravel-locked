<?php

namespace Sfolador\Locked\Traits;

trait Unlockable
{
    public function unlock(): self
    {
        $this->locked_at = null;
        $this->save();

        return $this;
    }

    public function isUnlocked(): bool
    {
        return  $this->locked_at == null;
    }

    public function isNotUnlocked(): bool
    {
        return ! $this->isUnlocked();
    }
}
