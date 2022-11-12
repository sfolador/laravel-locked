<?php

namespace Sfolador\Locked\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LockedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('locked_at', '!=', null);
    }
}
