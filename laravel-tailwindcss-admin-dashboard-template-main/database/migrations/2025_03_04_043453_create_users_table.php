<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idusers'); // PRIMARY KEY + AUTO_INCREMENT
            $table->string('nik', 45)->unique();
            $table->string('email', 45)->unique();
            $table->string('password', 255);
            $table->string('full_name', 45);
            $table->string('department', 45)->nullable();
            $table->string('location', 45)->nullable();
            $table->string('division', 45)->nullable();
            $table->string('position', 45)->nullable();
            $table->string('session', 45)->nullable();
            $table->timestamps();
            $table->string('otp_code', 45)->nullable();
            $table->datetime('otp_expiration')->nullable();
            $table->datetime('last_activity')->nullable();
            $table->datetime('session_exp')->nullable();

            // Foreign Key ke Departments
            $table->unsignedBigInteger('departments_iddepartments')->nullable();
            $table->foreign('departments_iddepartments')->references('iddepartments')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
