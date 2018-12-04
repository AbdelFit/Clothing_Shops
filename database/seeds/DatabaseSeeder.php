<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BrandsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(BlogsTableSeeder::class);

    }
}
