<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->longText('paymentid')->nullable();
            $table->integer('status')->nullable();
            $table->string('payment_used')->nullable();
            $table->float('delivery_fee', 8, 2)->nullable();
            $table->float('total_price', 8, 2);
            $table->integer('trayid')->nullable();
            $table->float('tray_remaining', 8, 2)->nullable();
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
        Schema::dropIfExists('order');
    }
}
