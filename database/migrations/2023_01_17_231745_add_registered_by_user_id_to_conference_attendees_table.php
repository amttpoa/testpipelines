<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisteredByUserIdToConferenceAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conference_attendees', function (Blueprint $table) {
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
        Schema::table('conference_attendees', function (Blueprint $table) {
            $table->dropColumn('registered_by_user_id');
        });
    }
}
