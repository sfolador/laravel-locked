<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Sfolador\Locked\Tests\TestCase;

uses(TestCase::class)->in('LockedServiceProviderTest');
uses(RefreshDatabase::class)->in('LockedServiceProviderTest');

beforeAll(function () {
    $files = __DIR__.'/../vendor/orchestra/testbench-core/laravel/database/migrations';
    //delete files
    $files = glob($files.'/*'); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file);
        } // delete file
    }
});
