<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
            'is_admin' => true
        ]);

        // Create 10 non-admin users
        User::factory()->count(10)->create();

        // \App\Models\User::factory(10)->create();
    }
}
