<?php

use App\Admin;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        Admin::insert([
            ['name' => "admin", 'email' => "admin@admin.com", 'password' => bcrypt('admin'), 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
