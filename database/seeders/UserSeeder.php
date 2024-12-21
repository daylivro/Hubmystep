<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Fonctionnel',
            'email' => config('hub.system_admin_email'),
            'password' => bcrypt(config('hub.system_admin_password')),
            'phone' => '1234567890',
        ])->assignRole(RoleEnum::SUPER_ADMIN);
    }
}
