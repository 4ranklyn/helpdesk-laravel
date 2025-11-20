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
                'unit_id' => 1,
                'name' => 'Gangguan Jaringan',
            ],
            [
                'unit_id' => 1,
                'name' => 'Kerusakan Perangkat Komputer',
            ],
            [
                'unit_id' => 1,
                'name' => 'Permintaan Akun Baru',
            ],
            [
                'unit_id' => 2,
                'name' => 'Kekurangan Stok Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Kesalahan Label Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Permintaan Pembaruan Data Obat',
            ],
            [
                'unit_id' => 3,
                'name' => 'Inspeksi Keselamatan',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pelaporan Kecelakaan Kerja',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pemeriksaan APD',
            ],
            [
                'unit_id' => 4,
                'name' => 'Kerusakan Instalasi Listrik',
            ],
            [
                'unit_id' => 4,
                'name' => 'Masalah AC dan Ventilasi',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perawatan Berkala',
            ],
            [
                'unit_id' => 5,
                'name' => 'Peralatan Steril Hilang',
            ],
            [
                'unit_id' => 5,
                'name' => 'Autoclave Bermasalah',
            ],
            [
                'unit_id' => 5,
                'name' => 'Permintaan Sterilisasi Mendesak',
            ],
            [
                'unit_id' => 6,
                'name' => 'Kebersihan Ruangan',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pengelolaan Sampah',
            ],
            [
                'unit_id' => 6,
                'name' => 'Peralatan Kebersihan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Keterlambatan Distribusi Makanan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Menu Tidak Sesuai Diet',
            ],
            [
                'unit_id' => 7,
                'name' => 'Kualitas Bahan Makanan',
            ],
            [
                'unit_id' => 8,
                'name' => 'Linen Kotor Tidak Diambil',
            ],
            [
                'unit_id' => 8,
                'name' => 'Linen Hilang atau Tertukar',
            ],
            [
                'unit_id' => 8,
                'name' => 'Kualitas Cuci Buruk',
            ],
        ]);
    }
}