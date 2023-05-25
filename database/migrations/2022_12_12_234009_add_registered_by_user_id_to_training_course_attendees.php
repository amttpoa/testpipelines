<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisteredByUserIdToTrainingCourseAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_course_attendees', function (Blueprint $table) {
            $table->foreignId('registered_by_user_id')->nullable()->after('completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_course_attendees', function (Blueprint $table) {
            $table->dropColumn('registered_by_user_id');
        });
    }
}
