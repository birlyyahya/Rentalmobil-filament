<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'username' => 'admin',
        //     'password' => '12345678',
        //     'email' => 'admin@admin.com',
        // ]);
        \App\Models\Reservasi::factory()->count(2)->create();
        // \App\Models\Mobil::factory()->count(2)->create();
    }
}
