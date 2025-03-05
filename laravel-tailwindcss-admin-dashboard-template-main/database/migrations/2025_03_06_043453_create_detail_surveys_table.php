<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_surveys', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY + AUTO_INCREMENT

            // Foreign Keys
            $table->unsignedBigInteger('surveys_idsurveys');
            $table->unsignedBigInteger('questions_idquestions');
            $table->unsignedBigInteger('answers_idanswers');

            $table->foreign('surveys_idsurveys')->references('idsurveys')->on('surveys')->onDelete('cascade');
            $table->foreign('questions_idquestions')->references('idquestions')->on('questions')->onDelete('cascade');
            $table->foreign('answers_idanswers')->references('idanswers')->on('answers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_surveys');
    }
};
