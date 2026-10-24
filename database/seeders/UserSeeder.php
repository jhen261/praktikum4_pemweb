<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Editor Desa',
            'email' => 'editor@desa.test',
            'password' => 'password',
            'role' => 'editor',
        ]);
    }
}
