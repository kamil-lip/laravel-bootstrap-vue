<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'superadmin',
            'email' => 'somename@thisemaildoesnotexists.com',
            'password' => bcrypt('dsfjks12D'),
        ]);
        factory(App\User::class, 50)->create();
    }
}
