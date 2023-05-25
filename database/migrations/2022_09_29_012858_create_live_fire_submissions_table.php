<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveFireSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_fire_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_registration_submission_id');
            $table->foreignId('user_id')->nullable();
            $table->string('bringing')->nullable();
            $table->string('firearm')->nullable();
            $table->string('caliber')->nullable();
            $table->string('share')->nullable();
            $table->string('share_with')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('live_fire_submissions');
    }
}
