<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_subscription', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->dateTime('borrow_date');
            $table->date('return_date')->nullable();
            $table->string('identity_national_num')->nullable();
            $table->integer('mortgage_amount')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_subscription');
    }
}
