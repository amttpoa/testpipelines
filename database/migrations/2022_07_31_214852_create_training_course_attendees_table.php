<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingCourseAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_course_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_course_id');
            $table->foreignId('user_id');
            $table->float('total')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('purchase_order')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('stripe_status')->nullable();
            $table->string('notes', 1000)->nullable();
            $table->boolean('paid')->nullable()->default(0);
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
        Schema::dropIfExists('training_course_attendees');
    }
}
