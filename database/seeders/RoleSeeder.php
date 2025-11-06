<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'description' => 'Regular user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'moderator',
                'description' => 'Moderator with content management access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
