<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $roles = ['admin', 'member'];
        foreach(range(0, 100) as $i){
            User::create([
                'id' => Str::uuid(),
                'username' => $faker->unique()->userName(),
                'full_name' => $faker->name,
                'password' => Hash::make('admin123'),
                'role' => $roles[rand(0, 10) < 2 ? 0 : 1],
                'photo' => null
            ]);
        }
    }
}
