<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cool_users = array(
            [
                'name' => 'cool user',
                'username' => 'coolUserName',
                'password' => bcrypt('coolPassword'),
                'is_admin' => 0
            ],
            [
                'name' => 'another cool user',
                'username' => 'anotherUserName',
                'password' => bcrypt('anotherPassword'),
                'is_admin' => 0
            ],
            [
                'name' => 'cool admin',
                'username' => 'adminUserName',
                'password' => bcrypt('adminPassword'),
                'is_admin' => 1
            ]
        );
        DB::table('users')->insert($cool_users);
    }
}
