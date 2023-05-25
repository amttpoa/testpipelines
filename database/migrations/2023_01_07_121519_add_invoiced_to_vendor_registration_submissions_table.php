<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicedToVendorRegistrationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_registration_submissions', function (Blueprint $table) {
            $table->boolean('invoiced')->nullable()->after('advertising');
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
            $table->dropColumn('invoiced');
        });
    }
}
