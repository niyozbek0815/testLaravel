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
        $categories = Category::where('parent_id', "!=", null)->get();
        $user = User::first(); // Bitta foydalanuvchi tanlanadi (avval user seed qilingan bo‘lishi kerak)
        if (!$user) {
            $user = User::factory()->create(); // Agar user bo‘lmasa, yaratib olamiz
        }

        foreach ($categories as $category) {
            for ($i = 0; $i < 4; $i++) {
                $poster = Poster::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'region_id' => rand(1, 10),
                    'title' => $category->name . ' categoriyasi uchun e\'lon ' . ($i + 1),
                    'description' => 'Bu ' . $category->name . ' kategoriyasiga tegishli elon.',
                    'price' => rand(500000, 50000000),
                    'rooms' => rand(1, 10),
                    'bathrooms' => rand(1, 5),
                    'area' => rand(30, 500),
                    'type' => rand(0, 1) ? 'sale' : 'rent',
                    'furnished' => rand(0, 1),
                    'garage' => rand(0, 1),
                    'status' => true,
                    'images' => "images/" . rand(1, 5) . ".jpg",
                ]);
                $poster->hashtags()->attach([1, 2]);
            }
        }
    }
}