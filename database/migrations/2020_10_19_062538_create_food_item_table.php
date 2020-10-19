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
            $table->longText('description');
            $table->string('weight');
            $table->string('procedure');
            $table->float('price', 8, 2);
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
