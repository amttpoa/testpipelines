<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizeSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorize_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('organization_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('authorize_id')->nullable();
            $table->string('authorize_payment_id')->nullable();
            $table->string('authorize_plan')->nullable();
            $table->text('metadata')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::dropIfExists('authorize_subscriptions');
    }
}
