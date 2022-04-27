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
                'id' => 1,
                'name' => 'cool user',
                'username' => 'coolUserName',
                'password' => bcrypt('coolPassword'),
                'is_admin' => 0
            ],
            [
                'id' => 2,
                'name' => 'another cool user',
                'username' => 'anotherUserName',
                'password' => bcrypt('anotherPassword'),
                'is_admin' => 0
            ],
            [
                'id' => 3,
                'name' => 'cool admin',
                'username' => 'adminUserName',
                'password' => bcrypt('adminPassword'),
                'is_admin' => 1
            ]
        );

        foreach ($cool_users as $user) {
            \App\Models\User::updateOrCreate(['id' => $user['id']], $user);
        }
//        DB::table('users')->insert($cool_users);
    }
}
