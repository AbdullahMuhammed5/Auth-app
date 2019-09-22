<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $user = User::create([
            'first_name' => 'Abdullah',
            'last_name' => 'mohamed',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456as'),
            'phone' => '01187754669',
            'isAdmin' => 1
        ]);

        $role = Role::create(['name' => 'Admin', 'description' => 'Administrator']);

        $user->assignRole([$role->id]);
    }

}
