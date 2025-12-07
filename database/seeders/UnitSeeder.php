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
            ['name' => 'IT', 'telegram_group_id' => '-4890970835'],
            ['name' => 'Farmasi','telegram_group_id' => '-5092746701'],
            ['name' => 'K3','telegram_group_id' => '-5092746702'],
            ['name' => 'ISPRS','telegram_group_id' => '-5092746703'],
            ['name' => 'CSSD','telegram_group_id' => '-5092746704'],
            ['name' => 'Rumah Tangga','telegram_group_id' => '-5092746705'],
            ['name' => 'Gizi','telegram_group_id' => '-5092746706'],
            ['name' => 'Laundry','telegram_group_id' => '-5092746707'],
        ]);
    }
}