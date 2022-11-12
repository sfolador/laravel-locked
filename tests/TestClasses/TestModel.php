<?php

namespace Sfolador\Locked\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Sfolador\Locked\Traits\HasLocks;
use Sfolador\Locked\Traits\Lockable;

class TestModel extends Model
{
    use HasLocks;
}
