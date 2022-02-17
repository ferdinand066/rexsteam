<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Idle'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Horror'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Adventure'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Action'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Sports'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Strategy'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Role-Playing'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Puzzle'
        ]);
        Category::create([
            'id' => Str::uuid(),
            'name' => 'Simulation'
        ]);
    }
}
