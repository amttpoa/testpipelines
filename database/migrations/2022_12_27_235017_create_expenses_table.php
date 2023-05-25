<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->float('total')->nullable();
            $table->string('payer')->nullable();
            $table->integer('card')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('paid')->nullable();
            $table->string('subject_type')->nullable();
            $table->foreignId('subject_id')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
