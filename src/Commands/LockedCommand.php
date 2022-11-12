<?php

namespace Sfolador\Locked\Commands;

use Illuminate\Console\Command;

class LockedCommand extends Command
{
    public $signature = 'lock:add {model}';

    public $description = 'Add a migration to add locked columns to a model';

    public function handle(): int
    {
        //verify that the model type exists
        $model = $this->argument('model');
        if (!class_exists($model)) {
            $this->error("Model $model does not exist");
            return 1;
        }

        return self::SUCCESS;
    }
}
