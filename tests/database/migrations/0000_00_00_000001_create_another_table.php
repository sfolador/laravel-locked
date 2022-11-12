<?php

namespace Sfolador\Locked\Tests\database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anothers', function (Blueprint $table) {
            $table->id();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anothers');
    }
};
