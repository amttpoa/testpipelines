<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckinFieldsToVendorRegistrationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_registration_submissions', function (Blueprint $table) {
            $table->boolean('checked_in')->nullable()->after('comp');
            $table->dateTime('checked_in_at')->nullable()->after('checked_in');
            $table->foreignId('checked_in_by_user_id')->nullable()->after('checked_in_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_registration_submissions', function (Blueprint $table) {
            $table->dropColumn('checked_in');
            $table->dropColumn('checked_in_at');
            $table->dropColumn('checked_in_by_user_id');
        });
    }
}
