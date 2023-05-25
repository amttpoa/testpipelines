<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardFieldsToConferenceAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conference_attendees', function (Blueprint $table) {
            $table->string('card_first_name')->nullable()->after('registered_by_user_id');
            $table->string('card_last_name')->nullable()->after('card_first_name');
            $table->string('card_type')->nullable()->after('card_last_name');
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
            $table->dropColumn('card_first_name');
            $table->dropColumn('card_last_name');
            $table->dropColumn('card_type');
        });
    }
}
