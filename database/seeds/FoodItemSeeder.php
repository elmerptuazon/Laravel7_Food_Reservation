<?php

use Illuminate\Database\Seeder;
use App\FoodItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FoodItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fooditems = array([
            'name' => 'beef short ribs',
            'type' => 'meat',
            'description' => Str::random(200),
            'weight' => '700g',
            'procedure' => '10 Hr smoked',
            'price' => 2000.00,
            'image' => 'beef_short_ribs',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'pork ribs',
            'type' => 'meat',
            'description' => Str::random(200),
            'weight' => '',
            'procedure' => '',
            'price' => 4000.00,
            'image' => 'pork_ribs',
            'image_type' => 'jpeg'
        ],
        [
            'name' => 'brisket',
            'type' => 'meat',
            'description' => Str::random(200),
            'weight' => '',
            'procedure' => '',
            'price' => 7000.00,
            'image' => 'brisket',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'mashed potatoes',
            'type' => 'sidedish',
            'description' => Str::random(30),
            'weight' => '',
            'procedure' => '',
            'price' => 300.00,
            'image' => 'mashed_potatoes',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'crispy chicharon',
            'type' => 'sidedish',
            'description' => Str::random(30),
            'weight' => '',
            'procedure' => '',
            'price' => 100.00,
            'image' => 'chicharon',
            'image_type' => 'jpg'
        ]);

        foreach ($fooditems as $food_item) {
            // DB::table('invoice')->insert($invoice);
            FoodItem::create($food_item);
        }
    }
}
