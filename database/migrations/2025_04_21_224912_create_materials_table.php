<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_name');
            $table->string('material_type')->nullable();
            $table->text('material_link')->nullable();
            $table->foreignId('uploader_id')->nullable()->constrained('instructors')->onDelete('set null');
            $table->enum('uploader_role', ['admin', 'professor'])->nullable();
            $table->boolean('is_new')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
