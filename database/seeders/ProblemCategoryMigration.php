<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Seeder;

class ProblemCategoryMigration extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProblemCategory::insert([
            [
                'unit_id' => 3,
                'name' => 'Kebersihan',
            ],
            [
                'unit_id' => 1,
                'name' => 'Sistem Down',
            ],
            [
                'unit_id' => 2,
                'name' => 'Obat abis',
            ],
            [
                'unit_id' => 7,
                'name' => 'Gudang rusak',
            ],
        ]);
    }
}
