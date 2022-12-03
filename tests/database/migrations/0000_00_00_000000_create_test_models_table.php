<?php

namespace Sfolador\Locked\Tests\database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_models', function (Blueprint $table) {
            $table->id();

            $table->string('email')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('custom_locked_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_models');
    }
};
