<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id');
            $table->foreignId('link_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('venue_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('capacity')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
