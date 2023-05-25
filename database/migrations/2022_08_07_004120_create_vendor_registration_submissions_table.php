<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorRegistrationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_registration_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable();
            $table->foreignId('organization_id')->nullable();
            $table->foreignId('conference_id');
            $table->boolean('public')->nullable();
            $table->boolean('advertising')->nullable();
            $table->boolean('paid')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();
            $table->string('sponsorship');

            $table->string('advertising_name')->nullable();
            $table->string('advertising_email')->nullable();
            $table->string('advertising_phone')->nullable();

            $table->string('live_fire');
            $table->string('live_fire_name')->nullable();
            $table->string('live_fire_email')->nullable();
            $table->string('live_fire_phone')->nullable();

            $table->string('primary_name')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('primary_phone')->nullable();

            $table->string('lunch')->nullable();

            $table->string('power')->nullable();
            $table->string('tv')->nullable();
            $table->string('internet')->nullable();
            $table->string('tables')->nullable();

            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone');

            $table->string('comments')->nullable();

            $table->boolean('payment_agreement');
            $table->boolean('terms_agreement');

            $table->integer('lunch_qty')->nullable()->default(0);
            $table->integer('tables_qty')->nullable()->default(0);

            $table->float('sponsorship_price')->default(0);
            $table->float('live_fire_price')->default(0);
            $table->float('lunch_price')->nullable()->default(0);
            $table->float('power_price')->default(0);
            $table->float('tv_price')->nullable()->default(0);
            $table->float('internet_price')->default(0);
            $table->float('tables_price')->default(0);
            $table->float('total')->default(0);

            $table->string('image')->nullable();
            $table->string('website_description')->nullable();
            $table->string('notes', 1000)->nullable();

            $table->string('uuid')->nullable();
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
        Schema::dropIfExists('vendor_registration_submissions');
    }
}
