<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_customer', function (Blueprint $table) {
            $table->uuid('order_id');
            $table->uuid('user_id');
            $table->string('firstname')->nullable();
            $table->string('preposition')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('telephone')->nullable();
            $table->string('other_delivery')->nullable();
            $table->string('delivery_street')->nullable();
            $table->string('delivery_number')->nullable();
            $table->string('delivery_zipcode')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_customer');
    }
}
