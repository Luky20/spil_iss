<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('idquestions'); // PRIMARY KEY + AUTO_INCREMENT
            $table->string('questions', 45);

            // Foreign Keys ke Departments
            $table->unsignedBigInteger('idepartments_dari')->nullable();
            $table->unsignedBigInteger('idepartments_ke')->nullable();
            $table->enum('jenis_survey', ['internal', 'external']);

            $table->foreign('idepartments_dari')->references('iddepartments')->on('departments')->onDelete('set null');
            $table->foreign('idepartments_ke')->references('iddepartments')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
