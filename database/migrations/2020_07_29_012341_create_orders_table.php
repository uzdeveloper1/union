<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->integer('items_count');
            $table->integer('items_qty');
            $table->unsignedBigInteger('order_sub_total');
            $table->unsignedBigInteger('discount');
            $table->unsignedBigInteger('delivery_cost');
            $table->unsignedBigInteger('total_payable');
            $table->integer('payment_method_id')->nullable()->default(1);
            $table->integer('status_id')->nullable()->default(1);
            $table->integer('customer_id')->nullable();
            $table->boolean('is_guest')->nullable();
            $table->string('city');
            $table->string('region');
            $table->string('street');
            $table->string('home_number');
            $table->string('level_flat')->nullable();
            $table->string('flat')->nullable();
            $table->string('entrance')->nullable();//Podyezd
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
        Schema::dropIfExists('orders');
    }
}
