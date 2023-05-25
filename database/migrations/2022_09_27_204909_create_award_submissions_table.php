<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id');
            $table->string('name_submitter');
            $table->string('agency_submitter')->nullable();
            $table->string('email_submitter')->nullable();
            $table->string('phone_submitter')->nullable();
            $table->string('preferred_contact')->nullable();
            $table->date('incident_date')->nullable();
            $table->text('story')->nullable();
            $table->string('image')->nullable();
            $table->string('logo')->nullable();
            $table->string('video')->nullable();
            $table->string('name_candidate')->nullable();
            $table->string('agency_candidate')->nullable();
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
        Schema::dropIfExists('award_submissions');
    }
}
