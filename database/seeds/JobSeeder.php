<?php

use App\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Job::create(
            [
                'name' => 'Writer',
                'description' => 'Write posts and publish it.'
            ]
         );

        Job::create([
            'name' => 'Reporter',
            'description' => 'Reports reports.'
        ]);
    }

}
