<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create user super admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        $superAdmin->syncRoles('Super Admin');

        // unit
        $units = [
            1 => 'IT',
            2 => 'Farmasi',
            3 => 'K3',
            4 => 'ISPRS',
            5 => 'CSSD',
            6 => 'Rumah Tangga',
            7 => 'Gizi',
            8 => 'Laundry',
        ];

        // create user admin dan staff untuk tiap unit
        foreach ($units as $id => $name) {

            // Admin Unit
            User::factory()->create([
                'name' => "Admin $name",
                'email' => 'admin' . strtolower(str_replace(' ', '', $name)) . '@example.com',
                'unit_id' => $id,
            ])->syncRoles('Admin Unit');

            // Staff Unit 1
            User::factory()->create([
                'name' => "Staff $name 1",
                'email' => 'staff_' . strtolower(str_replace(' ', '', $name)) . '1@example.com',
                'unit_id' => $id,
            ])->syncRoles('Staff Unit');

            // Staff Unit 2
            User::factory()->create([
                'name' => "Staff $name 2",
                'email' => 'staff_' . strtolower(str_replace(' ', '', $name)) . '2@example.com',
                'unit_id' => $id,
            ])->syncRoles('Staff Unit');
        }

        // create user
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        // create user manajemen rs
        User::factory()->create([
            'name' => 'Manajemen Rumah Sakit',
            'email' => 'manajemen_rs@example.com',
        ])->syncRoles('Manajemen Rumah Sakit');
    }
}