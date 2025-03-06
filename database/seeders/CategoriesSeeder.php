<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            [
                "name" => "Kvartiralar",
                "description" => "Ko‘p qavatli uylardagi kvartiralar",
                "subcategories" => [
                    ["name" => "Yangi", "description" => "Yangi qurilgan ko‘p qavatli uylar"],
                    ["name" => "Ikkinchi", "description" => "Oldin ishlatilgan kvartiralar"],
                    ["name" => "Luks", "description" => "Premium toifadagi kvartiralar"],
                ]
            ],
            [
                "name" => "Hovlilar",
                "description" => "Shaxsiy hovlili uylar",
                "subcategories" => [
                    ["name" => "Yangi", "description" => "Yangi qurilgan hovlilar"],
                    ["name" => "Eski", "description" => "Eski hovlilar, ta’mir talab"],
                    ["name" => "Villa", "description" => "Hasamatli villalar"],
                ]
            ],
            [
                "name" => "Tijorat",
                "description" => "Biznes uchun mo‘ljallangan binolar",
                "subcategories" => [
                    ["name" => "Ofis", "description" => "Ofis uchun mo‘ljallangan binolar"],
                    ["name" => "Savdo do‘konlari", "description" => "Savdo markazlari va do‘konlar"],
                    ["name" => "Omborxonalar", "description" => "Yuk saqlash uchun maxsus joylar"],
                ]
            ],
            [
                "id" => 4,
                "name" => "Dachalar",
                "description" => "Shahardan tashqaridagi dam olish uchun uylar",
                "subcategories" => []
            ],
            [
                "name" => "Yer uchastkalari",
                "subcategories" => [
                    ["name" => "Shahar ichida", "description" => "Shahar ichidagi yer uchastkalari"],
                    ["name" => "Shahar tashqarisida", "description" => "Shahar tashqarisidagi yer uchastkalari"],
                    ["name" => "Qishloq xo‘jaligi", "description" => "Fermalar va ekin yerlari uchun"],
                ]
            ],
        ];

        // Kategoriyalarni qo'shish
        foreach ($categories as $category) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => $category['name'],
                'slug' => mb_strtolower($category['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Subkategoriyalarni qo'shish
            if (!empty($category['subcategories'])) {
                foreach ($category['subcategories'] as $subcategory) {
                    $text = $category['name'] . '_' . $subcategory['name'];
                    DB::table('categories')->insert([
                        'parent_id' => $categoryId,
                        'name' => $subcategory['name'],
                        'slug' => mb_strtolower($text),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}