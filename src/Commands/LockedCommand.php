<?php

namespace Sfolador\Locked\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LockedCommand extends Command
{
    public $signature = 'lock:add {model}';

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
        //verify that the model type exists
        $model = $this->argument('model');
        if (! class_exists($model)) {
            $this->error("Model $model does not exist");

            return self::FAILURE;
        }

        $instance = new $model;
        $fileContents = $this->getStubContents($this->getStubPath(), [
            'ModelTable' => $instance->getTable(),
        ]);


        $filePath = now()->format('Y_m_d_His').'_add_locked_columns_to_'.$instance->getTable().'.php';
        $path = app()->databasePath('migrations/'.$filePath);

        if (! $this->files->exists($path)) {
            $this->files->put($path, $fileContents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }

        return self::SUCCESS;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
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
