<?php

namespace Sfolador\Locked\Commands;

use Illuminate\Console\Command;

class LockedCommand extends Command
{
    public $signature = 'lock:add {model}';

    public $description = 'Add lock to a model';

    public function handle(): int
    {

        $this->comment('All done');

        return self::SUCCESS;
    }
}
