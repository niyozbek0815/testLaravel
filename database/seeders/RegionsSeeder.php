<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['id' => 1, 'name' => "Qoraqalpog‘iston Respublikasi"],
            ['id' => 2, 'name' => "Andijon viloyati"],
            ['id' => 3, 'name' => "Buxoro viloyati"],
            ['id' => 4, 'name' => "Jizzax viloyati"],
            ['id' => 5, 'name' => "Qashqadaryo viloyati"],
            ['id' => 6, 'name' => "Navoiy viloyati"],
            ['id' => 7, 'name' => "Namangan viloyati"],
            ['id' => 8, 'name' => "Samarqand viloyati"],
            ['id' => 9, 'name' => "Surxandaryo viloyati"],
            ['id' => 10, 'name' => "Sirdaryo viloyati"],
            ['id' => 11, 'name' => "Toshkent viloyati"],
            ['id' => 12, 'name' => "Farg‘ona viloyati"],
            ['id' => 13, 'name' => "Xorazm viloyati"],
            ['id' => 14, 'name' => "Toshkent viloyati"],
            ['id' => 15, 'name' => "Toshkent shahri"],
        ];

        DB::table('regions')->insert($regions);
    }
}