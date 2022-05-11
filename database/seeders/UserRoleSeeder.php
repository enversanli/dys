<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'key' => UserRoleKeyEnum::ADMIN,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::ADMIN->name))
            ],
            [
                'key' => UserRoleKeyEnum::ASSOCIATION_MANAGER,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::ASSOCIATION_MANAGER->name))
            ],
            [
                'key' => UserRoleKeyEnum::STUDENT,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::STUDENT->name))
            ],
            [
                'key' => UserRoleKeyEnum::TEACHER,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::TEACHER->name))
            ],
            [
                'key' => UserRoleKeyEnum::PARENT,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::PARENT->name))
            ],
            [
                'key' => UserRoleKeyEnum::SUB_ASSOCIATION_MANAGER,
                'name' => Str::upper(Str::replace('_', ' ', UserRoleKeyEnum::SUB_ASSOCIATION_MANAGER->name))
            ],
        ];

        UserRole::insert($data);

    }
}
