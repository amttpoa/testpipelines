<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('upload_folder_id');
            $table->string('name');
            $table->string('file_name');
            $table->string('file_original');
            $table->string('file_ext')->nullable();
            $table->string('description')->nullable();
            $table->string('size')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('protected')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_files');
    }
}
