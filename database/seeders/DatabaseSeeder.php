<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'accountant']);

        Permission::create(['name' => 'send-message']);

        $admin = User::create(['name' => 'admin'
            , 'email' => 'admin@admin.com',
            'password' => bcrypt('admin1234')
        ]);
        $admin->removeRole('user');
        $admin->assignRole('admin');
        User::create(['name' => 'user'
            , 'email' => 'user@user.com',
            'password' => bcrypt('user1234')
        ]);
        $accountant = User::create(['name' => 'accountant'
            , 'email' => 'acc@acc.com',
            'password' => bcrypt('account1234')
        ]);
        $accountant->removeRole('user');
        $accountant->assignRole('accountant');

    }
}
