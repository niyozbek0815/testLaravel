<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'password' => Hash::make('password'),
        ]);
        $this->call(RegionsSeeder::class);
        $this->call(HashtagSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostersSeeder::class);
    }
}
