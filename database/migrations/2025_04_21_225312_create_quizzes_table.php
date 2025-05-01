<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('quiz_name');
            $table->text('description')->nullable();
            $table->date('quiz_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
