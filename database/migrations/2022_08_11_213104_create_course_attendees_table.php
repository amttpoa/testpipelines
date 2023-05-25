<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_attendee_id');
            $table->foreignId('course_id');
            $table->foreignId('user_id');
            $table->string('notes', 1000)->nullable();
            $table->boolean('checked_in')->nullable()->default(0);
            $table->boolean('completed')->nullable()->default(0);
            $table->string('admin_notes', 1000)->nullable();
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
        Schema::dropIfExists('course_attendees');
    }
}
