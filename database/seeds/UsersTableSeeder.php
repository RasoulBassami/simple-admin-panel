<?php

use Illuminate\Database\Seeder;
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
            ],
            [
                'id' => 4,
                'name' => 'cool limited admin',
                'username' => 'limitedAdminUserName',
                'password' => bcrypt('limitedAdminPassword'),
                'is_admin' => 1
            ]
        );

        $permissions = array(
            [
                '1', '2', '3', '4',
            ],
            [
                '1', '2', '3', '4',
            ],
            [
                '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12',
            ],
            [
                '2', '3', '5', '6', '7', '8', '10'
            ],
        );

        $i = 0;
        foreach ($cool_users as $user) {
            $newUser = \App\Models\User::firstOrCreate(['id' => $user['id']], $user);
            $newUser->permissions()->sync($permissions[$i++]);
        }
    }
}
