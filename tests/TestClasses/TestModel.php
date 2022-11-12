<?php

namespace Sfolador\Locked\Tests\TestClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sfolador\Locked\Tests\database\factories\TestModelFactory;
use Sfolador\Locked\Traits\HasLocks;

class TestModel extends Model
{
    use HasLocks;
    use HasFactory;


    protected static function newFactory()
    {
        return TestModelFactory::new();
    }
}
