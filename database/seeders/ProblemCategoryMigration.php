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
            // IT (Unit 1)
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
                'unit_id' => 1,
                'name' => 'Masalah Printer',
            ],
            [
                'unit_id' => 1,
                'name' => 'Akses Aplikasi Terblokir',
            ],
            [
                'unit_id' => 1,
                'name' => 'Pemasangan Software',
            ],
            [
                'unit_id' => 1,
                'name' => 'Gangguan Email',
            ],
            [
                'unit_id' => 1,
                'name' => 'Masalah Server',
            ],
            [
                'unit_id' => 1,
                'name' => 'Pemulihan Data',
            ],
            [
                'unit_id' => 1,
                'name' => 'Konfigurasi Jaringan Baru',
            ],
            [
                'unit_id' => 1,
                'name' => 'Pembaruan Sistem',
            ],
            [
                'unit_id' => 1,
                'name' => 'Keamanan IT',
            ],
            [
                'unit_id' => 1,
                'name' => 'Pelatihan Pengguna',
            ],
            [
                'unit_id' => 1,
                'name' => 'Backup Data',
            ],

            // Farmasi (Unit 2)
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
                'unit_id' => 2,
                'name' => 'Kadaluarsa Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Permintaan Obat Khusus',
            ],
            [
                'unit_id' => 2,
                'name' => 'Penyimpanan Obat Tidak Sesuai',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pencatatan Stok Tidak Akurat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Permintaan Resep Darurat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Konsultasi Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pemusnahan Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pendistribusian Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pemantauan Efek Samping Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pemesanan Obat',
            ],
            [
                'unit_id' => 2,
                'name' => 'Pengelolaan Obat Narkotika',
            ],

            // K3 (Unit 3)
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
                'unit_id' => 3,
                'name' => 'Pemantauan Kebisingan',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pemeriksaan Kualitas Udara',
            ],
            [
                'unit_id' => 3,
                'name' => 'Penyelidikan Insiden',
            ],
            [
                'unit_id' => 3,
                'name' => 'Sertifikasi Alat Berat',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pemantauan Bahan Kimia Berbahaya',
            ],
            [
                'unit_id' => 3,
                'name' => 'Audit K3',
            ],
            [
                'unit_id' => 3,
                'name' => 'Penyusunan Prosedur Darurat',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pemantauan Ergonomi',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pengelolaan Limbah B3',
            ],
            [
                'unit_id' => 3,
                'name' => 'Pemantauan Kebakaran',
            ],
            [
                'unit_id' => 3,
                'name' => 'Penyuluhan K3',
            ],

            // ISPRS (Unit 4)
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
                'unit_id' => 4,
                'name' => 'Pemasangan Peralatan Baru',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perbaikan Pipa Air',
            ],
            [
                'unit_id' => 4,
                'name' => 'Pemeliharaan Generator',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perbaikan Lift',
            ],
            [
                'unit_id' => 4,
                'name' => 'Pemeliharaan Sistem Pemadam Kebakaran',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perbaikan Atap Bocor',
            ],
            [
                'unit_id' => 4,
                'name' => 'Pemeliharaan Taman',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perbaikan Pagar',
            ],
            [
                'unit_id' => 4,
                'name' => 'Pemeliharaan Jalan dan Parkir',
            ],
            [
                'unit_id' => 4,
                'name' => 'Perbaikan Plafon',
            ],
            [
                'unit_id' => 4,
                'name' => 'Pemeliharaan Sistem Plumbing',
            ],

            // CSSD (Unit 5)
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
                'unit_id' => 5,
                'name' => 'Kualitas Sterilisasi Tidak Optimal',
            ],
            [
                'unit_id' => 5,
                'name' => 'Peralatan Rusak',
            ],
            [
                'unit_id' => 5,
                'name' => 'Kekurangan Kemasan Steril',
            ],
            [
                'unit_id' => 5,
                'name' => 'Pencatatan Tidak Akurat',
            ],
            [
                'unit_id' => 5,
                'name' => 'Pemeliharaan Peralatan',
            ],
            [
                'unit_id' => 5,
                'name' => 'Permintaan Khusus Peralatan',
            ],
            [
                'unit_id' => 5,
                'name' => 'Penyimpanan Peralatan',
            ],
            [
                'unit_id' => 5,
                'name' => 'Pemantauan Suhu dan Kelembaban',
            ],
            [
                'unit_id' => 5,
                'name' => 'Pembuangan Limbah Medis',
            ],
            [
                'unit_id' => 5,
                'name' => 'Pencucian Peralatan',
            ],
            [
                'unit_id' => 5,
                'name' => 'Validasi Sterilisasi',
            ],

            // Rumah Tangga (Unit 6)
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
                'unit_id' => 6,
                'name' => 'Permintaan Kebersihan Khusus',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pembersihan Tumpahan Bahan Berbahaya',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pemeliharaan Lantai',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pembersihan Karpet',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pengendalian Hama',
            ],
            [
                'unit_id' => 6,
                'name' => 'Penyediaan Sabun dan Hand Sanitizer',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pembersihan Jendela',
            ],
            [
                'unit_id' => 6,
                'name' => 'Penyimpanan Alat Kebersihan',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pembersihan Area Luar',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pencahayaan Ruangan',
            ],
            [
                'unit_id' => 6,
                'name' => 'Pengelolaan Tempat Sampah',
            ],

            // Gizi (Unit 7)
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
                'unit_id' => 7,
                'name' => 'Permintaan Diet Khusus',
            ],
            [
                'unit_id' => 7,
                'name' => 'Kebersihan Dapur',
            ],
            [
                'unit_id' => 7,
                'name' => 'Penyimpanan Bahan Makanan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Konsultasi Gizi',
            ],
            [
                'unit_id' => 7,
                'name' => 'Peralatan Dapur Rusak',
            ],
            [
                'unit_id' => 7,
                'name' => 'Kebersihan Peralatan Makan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Pengelolaan Sisa Makanan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Penyajian Makanan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Kebersihan Ruang Makan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Pencatatan Konsumsi Makanan',
            ],
            [
                'unit_id' => 7,
                'name' => 'Permintaan Makanan Tambahan',
            ],

            // Laundry (Unit 8)
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
            [
                'unit_id' => 8,
                'name' => 'Keterlambatan Pengiriman Linen',
            ],
            [
                'unit_id' => 8,
                'name' => 'Kebocoran Air',
            ],
            [
                'unit_id' => 8,
                'name' => 'Mesin Cuci Rusak',
            ],
            [
                'unit_id' => 8,
                'name' => 'Penyimpanan Linen',
            ],
            [
                'unit_id' => 8,
                'name' => 'Permintaan Khusus Linen',
            ],
            [
                'unit_id' => 8,
                'name' => 'Pemilahan Linen',
            ],
            [
                'unit_id' => 8,
                'name' => 'Pencucian Khusus',
            ],
            [
                'unit_id' => 8,
                'name' => 'Penyetrikaan Linen',
            ],
            [
                'unit_id' => 8,
                'name' => 'Kualitas Bahan Pencuci',
            ],
            [
                'unit_id' => 8,
                'name' => 'Pemeliharaan Peralatan',
            ],
            [
                'unit_id' => 8,
                'name' => 'Pencatatan Linen',
            ],
        ]);
    }
}