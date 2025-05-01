<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('content');
            $table->json('files')->nullable()->after('content');
            $table->timestamp('publish_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
