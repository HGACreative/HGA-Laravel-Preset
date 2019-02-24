<?php

use App\Models\Role;
use App\Models\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

/**
 * @since 1.0.0
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => ($firstName = 'Ian'),
                'last_name' => ($lastName = 'Austin'),
                'email' => "{$firstName}.{$lastName}@hgacreative.com",
                'password' => Hash::make(Str::random(10)),
                'role_id' => 1,
            ],
            [
                'first_name' => ($firstName = 'Reece'),
                'last_name' => ($lastName = 'Farmer'),
                'email' => "{$firstName}.{$lastName}@hgacreative.com",
                'password' => Hash::make(Str::random(10)),
                'role_id' => 1,
            ],
            [
                'first_name' => ($firstName = 'Tallah'),
                'last_name' => ($lastName = 'Kahn'),
                'email' => "{$firstName}@hgacreative.com",
                'password' => Hash::make(Str::random(10)),
                'role_id' => 1,
            ],
        ];

        foreach($users as $array) {
            $newUser = User::create(Arr::except($array, 'role_id'));
            $newUser->roles()->sync(Role::find(Arr::only($array, 'role_id')));
        }
    }
}
