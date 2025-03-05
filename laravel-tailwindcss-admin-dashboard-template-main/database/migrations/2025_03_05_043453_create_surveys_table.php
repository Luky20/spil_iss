<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id('idsurveys'); // PRIMARY KEY + AUTO_INCREMENT
            $table->datetime('tanggal');

            // Foreign Key ke Users
            $table->unsignedBigInteger('users_idusers');
            $table->foreign('users_idusers')->references('idusers')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
};
