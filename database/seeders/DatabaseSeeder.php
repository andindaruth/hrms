<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Fuel;
use App\Models\Lub;
use App\Models\User;
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
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Andinda Ruth', 
            'role' => 'Admin',           
            'email' => 'andindaruth@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password           
        ]);

        Fuel::create([             
            'type' => 'Diesel',           
            'balance' => '0.00',      
        ]);

        Lub::create([             
            'type' => 'Oil',           
            'balance' => '0.00',      
        ]);
    }
}
