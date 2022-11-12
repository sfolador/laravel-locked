<?php

namespace Sfolador\Locked\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sfolador\Locked\Locked
 */
class Locked extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sfolador\Locked\Locked::class;
    }
}
