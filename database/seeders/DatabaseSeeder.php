<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => Str::uuid(),
            'username' => 'admin',
            'full_name' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'id' => Str::uuid(),
            'username' => 'member',
            'full_name' => 'member',
            'password' => Hash::make('admin123'),
            'role' => 'member',
            'photo' => 'member.jpg'
        ]);

        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            GameSeeder::class
        ]);
    }
}
