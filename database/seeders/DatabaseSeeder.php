<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      // Super Admin
    User::create([
        'name' => 'Super Admin',
        'email' => 'admin@mail.com',
        'password' => Hash::make('123456'),
        'role' => 'admin'
    ]);

    // Staff
    User::create([
        'name' => 'Staff Insurance',
        'email' => 'staff@mail.com',
        'password' => Hash::make('123456'),
        'role' => 'staff'
    ]);
    }
}
