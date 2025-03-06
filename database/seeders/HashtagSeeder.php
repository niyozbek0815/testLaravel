<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HashtagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hashtag = [
            ['id' => 1, 'name' => "Yangi"],
            ['id' => 2, 'name' => "Ijara"],
            ['id' => 3, 'name' => "Sotuv"],
            ['id' => 4, 'name' => "Foydalanilgan"],
            ['id' => 5, 'name' => "Chegirma"]
        ];
        DB::table('hashtags')->insert($hashtag);
    }
}