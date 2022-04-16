<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeding demo user data.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => "Ms. Anderson",
            'username' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make('admin'),
            'parent_id' => null,
        ]);

        // Create another users with random parent_id from users table
        for ($i = 0; $i < 9; $i++) {
            User::factory()->create([
                'parent_id' => User::inRandomOrder()->first(),  // selects a random user from the database
            ]);
        }

    }
}
