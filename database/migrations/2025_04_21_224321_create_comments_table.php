<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('commenter_id')->nullable();
            $table->text('content');
            $table->date('comment_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
