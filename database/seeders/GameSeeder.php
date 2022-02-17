<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $categories = Category::all()->pluck('id');
        foreach(range(1, 15) as $i){
            Game::create([
                'id' => $faker->uuid(),
                'name' => $faker->realText(20),
                'short_desc' => $faker->realText(300),
                'long_desc' => $faker->realText(500),
                'category_id' => $categories[random_int(0, count($categories) - 1)],
                'developer' => $faker->company(),
                'publisher' => $faker->company(),
                'price' => random_int(10000, 900000),
                'cover' => $i . '.jpg',
                'trailer' => $i . '.webm',
                'restrict' => (random_int(1, 10) < 7) ? 0 : 1
            ]);
        }
    }
}
