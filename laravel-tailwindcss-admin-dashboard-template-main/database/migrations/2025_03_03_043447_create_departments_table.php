<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('iddepartments');
            $table->string('nama', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
