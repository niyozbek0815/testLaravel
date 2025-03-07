<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Poster;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::with('attributes')->where('parent_id', "!=", null)->get();
        $user = User::first(); // Bitta foydalanuvchi tanlanadi (avval user seed qilingan bo‘lishi kerak)
        if (!$user) {
            $user = User::factory()->create(); // Agar user bo‘lmasa, yaratib olamiz
        }
        $faker = \Faker\Factory::create();
        foreach ($categories as $category) {
            for ($i = 0; $i < 3; $i++) {
                $poster = Poster::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'region_id' => rand(1, 10),
                    'title' => $category->name . ' kategoriyasi uchun e\'lon ' . ($i + 1),
                    'description' => 'Bu ' . $category->name . ' kategoriyasiga tegishli e\'lon.',
                    'price' => rand(500000, 50000000),
                    'type' => ['sale', 'rent', 'service', 'exchange'][rand(0, 3)], // Yangilangan qiymatlar
                    'negotiable' => (bool)rand(0, 1),
                    'views' => 0,
                    'images' => "images/" . rand(1, 5) . ".jpg",
                ]);
                $poster->hashtags()->attach([1, 2]);
                    foreach ($category->attributes as $attribute) {
                    if ($attribute['type'] == "integer") {
                        $value = rand(1, 100);
                    } elseif ($attribute['type'] == "string") {
                        $value = $faker->sentence(3);
                    } elseif($attribute['type']=='decimal') {
                        $value = rand(1, 20);
                    }elseif($attribute['type']== 'boolean') {
                        $value = (bool)rand(0, 1);
                    } else {
                        $value = null;
                    }


                        $poster->attributes()->attach([
                            $attribute->id => ['value' => $value]
                        ]);
                }
            }
        }
    }
}

