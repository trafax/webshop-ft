<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_rules', function (Blueprint $table) {
            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->string('sku');
            $table->string('title');
            $table->integer('qty')->default(1);
            $table->longText('options')->nullable();
            $table->decimal('price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_rules');
    }
}
