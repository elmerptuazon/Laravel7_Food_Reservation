<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_item', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['meat', 'sidedish']);
            $table->longText('description')->nullable();
            $table->string('weight')->nullable();
            $table->string('procedure')->nullable();
            $table->integer('max_pcs_per_tray');
            $table->float('unit_price', 8, 2);
            $table->string('image')->default('');
            $table->string('image_type')->default('');
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
        Schema::dropIfExists('food_item');
    }
}
