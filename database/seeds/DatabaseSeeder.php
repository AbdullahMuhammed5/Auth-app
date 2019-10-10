<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(NewsSeeder::class);
    }
}
