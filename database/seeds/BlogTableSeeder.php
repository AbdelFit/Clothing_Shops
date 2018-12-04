<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Blog;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $faker = Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $Blog = Blog::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph(mt_rand(100, 2000)),
                'feature_image' => "realpixels.png",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
