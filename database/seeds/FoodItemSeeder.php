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
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'weight' => '700g',
            'procedure' => '10 Hr smoked',
            'price' => 2000.00,
            'image' => 'beef_short_ribs',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'pork ribs',
            'type' => 'meat',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'weight' => '',
            'procedure' => '',
            'price' => 4000.00,
            'image' => 'pork_ribs',
            'image_type' => 'jpeg'
        ],
        [
            'name' => 'brisket',
            'type' => 'meat',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'weight' => '',
            'procedure' => '',
            'price' => 7000.00,
            'image' => 'brisket',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'mashed potatoes',
            'type' => 'sidedish',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'weight' => '',
            'procedure' => '',
            'price' => 300.00,
            'image' => 'mashed_potatoes',
            'image_type' => 'jpg'
        ],
        [
            'name' => 'crispy chicharon',
            'type' => 'sidedish',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
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
