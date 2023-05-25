<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyConferenceCourseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_conference_course_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_conference_course_submission_id');
            $table->integer('num');
            $table->string('question');
            $table->string('answer');
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
        Schema::dropIfExists('survey_conference_course_lines');
    }
}
