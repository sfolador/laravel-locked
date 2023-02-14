<?php

namespace Sfolador\Locked\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LockedCommand extends Command
{
    public $signature = 'lock:add {model} {--namespace=}';

    public $description = 'Add a migration to add locked columns to a model';

    /**
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files = $filesystem;
    }

    public function handle(): int
    {
        $model = $this->argument('model');

        $namespace = config('locked.default_namespace');
        if ($this->option('namespace')) {
            $namespace = $this->option('namespace');
        }

        $className = $namespace.'\\'.$model;

        if (! class_exists($className)) {
            $this->error("Model $className does not exist");

            return self::FAILURE;
        }

        $instance = new $className();
        $fileContents = $this->getStubContents($this->getStubPath(), [
            'ModelTable' => $instance->getTable(),
        ]);

        $filePath = now()->format('Y_m_d_His').'_add_locked_columns_to_'.$instance->getTable().'.php';
        $path = app()->databasePath('migrations/'.$filePath);

        if (! $this->files->exists($path)) {
            $this->files->put($path, $fileContents);
        } else {
            $this->info("File : $path already exists");
        }

        return self::SUCCESS;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param  array  $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Return the stub file path
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__.'/../../database/migrations/add_locked_column_to_table.php.stub';
    }
}
