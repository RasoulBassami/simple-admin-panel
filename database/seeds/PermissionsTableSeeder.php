<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $predefined_permissions = array(
            [
                'id' => 1,
                'name' => 'create-post',
                'label' => 'ایجاد پست جدید'
            ],
            [
                'id' => 2,
                'name' => 'view-posts',
                'label' => 'مشاهده پست ها'
            ],
            [
                'id' => 3,
                'name' => 'update-post',
                'label' => 'ویرایش پست'
            ],
            [
                'id' => 4,
                'name' => 'delete-post',
                'label' => 'حذف پست'
            ],
            [
                'id' => 5,
                'name' => 'create-user',
                'label' => 'ایجاد کاربر'
            ],
            [
                'id' => 6,
                'name' => 'view-users',
                'label' => 'مشاهده کاربران'
            ],
            [
                'id' => 7,
                'name' => 'update-user',
                'label' => 'ویرایش کاربر'
            ],
            [
                'id' => 8,
                'name' => 'delete-user',
                'label' => 'حذف کاربر'
            ],
            [
                'id' => 9,
                'name' => 'create-admin-user',
                'label' => 'ایجاد کاربر ادمین'
            ],
            [
                'id' => 10,
                'name' => 'view-admin-users',
                'label' => 'مشاهده کاربران ادمین'
            ],
            [
                'id' => 11,
                'name' => 'update-admin-user',
                'label' => 'ویرایش کاربر ادمین'
            ],
            [
                'id' => 12,
                'name' => 'delete-admin-user',
                'label' => 'حذف کاربر ادمین'
            ],
        );

        foreach ($predefined_permissions as $permission) {
            \App\Models\Permission::updateOrCreate(['id' => $permission['id']], $permission);
        }
    }
}
