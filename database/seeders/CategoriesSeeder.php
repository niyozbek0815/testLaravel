<?php

namespace Database\Seeders;

use App\Models\Attribute;
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
        $data = [
            [
                "name" => "Ko'chmas mulk",
                "subcategories" => [
                    [
                        "name" => "Kvartiralar",
                        "attributes" => [
                            ["key" => "rooms", "type" => "integer"],
                            ["key" => "area", "type" => "integer"],
                            ["key" => "balkon", "type" => "boolean"],
                        ],
                    ],
                    [
                        "name" => "Tijorat binolari",
                        "attributes" => [
                            ["key" => "area", "type" => "integer"],
                            ["key" => "floors", "type" => "string"],
                            ["key" => "rooms", "type" => "integer"],
                        ],
                    ],
                    [
                        "name" => "Xovlilar",
                        "attributes" => [
                            ["key" => "area", "type" => "integer"],
                            ["key" => "rooms", "type" => "integer"],
                            ["key" => "garage", "type" => "boolean"],
                        ],
                    ],
                ]
            ],
            [
                "name" => "Transport",
                "subcategories" => [
                    [
                        "name" => "Yengil automashinalar",
                        "attributes" => [
                            ["key" => "mileage", "type" => "integer"],
                            ["key" => "fuel_type", "type" => "string"],
                            ["key" => "ishlab chiqarilgan yili", "type" => "decimal"],
                        ],
                    ],
                    [
                        "name" => "Yuk mashinalar",
                        "attributes" => [
                            ["key" => "capacity", "type" => "integer"],
                            ["key" => "fuel_type", "type" => "string"],
                            ["key" => "haqdorlar", "type" => "decimal"],
                        ],
                    ],
                    [
                        "name" => "Mototransport",
                        "attributes" => [
                            ["key" => "engine_size", "type" => "integer"],
                            ["key" => "fuel_type", "type" => "string"],
                            ["key" => "haqdorlar", "type" => "decimal"],
                        ],
                    ],
                ]
            ],
            [
                "name" => "Elektronika",
                "subcategories" => [
                    [
                        "name" => "Telefon",
                        "attributes" => [
                            ["key" => "brand", "type" => "string"],
                            ["key" => "storage", "type" => "integer"],
                            ["key" => "ram", "type" => "decimal"],
                        ],
                    ],
                    [
                        "name" => "Audiotexnika",
                        "attributes" => [
                            ["key" => "brand", "type" => "string"],
                            ["key" => "power", "type" => "integer"],
                            ["key" => "storage", "type" => "decimal"],
                        ],
                    ],
                    [
                        "name" => "Kompyuterlar",
                        "attributes" => [
                            ["key" => "brand", "type" => "string"],
                            ["key" => "ram", "type" => "integer"],
                            ["key" => "storage", "type" => "integer"],
                            ["key" => "display size", "type" => "decimal"],
                        ],
                    ],
                ]
            ],
        ];
        DB::transaction(function () use ($data) {
            foreach ($data as $category) {
                $categoryId = DB::table('categories')->insertGetId([
                    'name' => $category['name'],
                    'slug' => mb_strtolower(str_replace(' ', '_', $category['name'])),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($category['subcategories'] as $subCategory) {
                    $subCategoryId = DB::table('categories')->insertGetId([
                        'parent_id' => $categoryId,
                        'name' => $subCategory['name'],
                        'slug' => mb_strtolower(str_replace(' ', '_', $category['name'] . '_' . $subCategory['name'])),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    foreach ($subCategory['attributes'] as $attributeData) {
                        $attribute = Attribute::firstOrCreate(['key' => $attributeData['key']], [
                            'type' => $attributeData['type'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table('attribute_category')->insert([
                            'category_id' => $subCategoryId,
                            'attribute_id' => $attribute->id,
                        ]);
                    }
                }
            }
        });
    }
}
