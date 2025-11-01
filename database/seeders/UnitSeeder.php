<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            ['name' => 'IT','telegram_group_id' => '-4890970835'],
            ['name' => 'Farmasi'],
            ['name' => 'K3'],
            ['name' => 'ISPRS'],
            ['name' => 'CSSD'],
            ['name' => 'Rumah Tangga'],
            ['name' => 'Gizi'],
            ['name' => 'Laundry'],
        ]);
    }
}
