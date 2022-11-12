<?php

namespace Sfolador\Locked\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Sfolador\Locked\Scopes\LockedScope;
use Sfolador\Locked\Scopes\UnlockedScope;
use Sfolador\Locked\Traits\HasLocks;


class TestModel extends Model
{
    use HasLocks;

    protected static function booted()
    {
       static::addGlobalScope(new LockedScope());
       static::addGlobalScope(new UnlockedScope());
    }
}
