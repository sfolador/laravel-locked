<?php

namespace Sfolador\Locked\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Sfolador\Locked\Traits\HasLocks;

class Another extends Model
{
    use HasLocks;
}
