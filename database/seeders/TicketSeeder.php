<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================
        // UNIT IT (id = 1)
        // ============================
        // Kategori 1 - Gangguan Jaringan (id = 1)

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 6, // staff farmasi 1
            'problem_category_id' => 1,
            'title' => 'Koneksi internet di ruang administrasi sering terputus',
            'description' => 'Selama seminggu terakhir jaringan di ruang administrasi sering disconnect, menyebabkan sistem absensi dan SIMRS tidak bisa diakses.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 08:14:00',
            'updated_at' => '2025-11-13 08:14:00',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 6, // staff Farmasi 1
            'responsible_id' => 3, // staff IT 1
            'problem_category_id' => 1,
            'title' => 'Jaringan di ruang Farmasi sering terputus',
            'description' => 'Koneksi internet di ruang Farmasi sering tiba-tiba terputus selama jam kerja. Hal ini menghambat proses input data obat dan membuat pelayanan menjadi lebih lambat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-01 08:14:33', 
            'updated_at' => '2025-10-01 08:14:33', 
            'approved_at' => '2025-10-01 10:22:10', 
            'solved_at' => '2025-10-01 15:47:39'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 12, // staff ISPRS 1
            'responsible_id' => 4, // staff IT 2
            'problem_category_id' => 1,
            'title' => 'Jaringan laboratorium lambat dan sering error',
            'description' => 'Koneksi jaringan di laboratorium ISPRS sangat lambat dan sering mengalami gangguan, terutama saat banyak perangkat digunakan bersamaan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-01 21:05:22', 
            'updated_at' => '2025-10-01 21:05:22',
            'approved_at' => '2025-10-02 08:33:47', 
            'solved_at' => '2025-10-02 20:11:56'
        ]);

        // Kategori 2 - Kerusakan Perangkat Komputer (id = 2)
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 9, // staff K3 1
            'responsible_id' => 4, // staff IT 2
            'problem_category_id' => 2,
            'title' => 'Komputer administrasi K3 tidak bisa menyala',
            'description' => 'Komputer di ruang administrasi K3 tidak bisa dinyalakan meskipun sudah dicek kabel dan listriknya.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-02 13:49:41', 
            'updated_at' => '2025-10-02 13:49:41', 
            'approved_at' => '2025-10-02 15:05:27', 
            'solved_at' => '2025-10-03 07:42:02'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 15, // staff CSSD 1
            'responsible_id' => 3, // staff it 1
            'problem_category_id' => 2,
            'title' => 'Monitor di ruang CSSD tidak menampilkan gambar',
            'description' => 'Monitor komputer di CSSD mati total padahal CPU masih menyala normal.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-03 09:03:14',
            'updated_at' => '2025-10-03 09:03:14', 
            'approved_at' => '2025-10-03 09:27:52', 
            'solved_at' => '2025-10-03 10:13:15'
        ]);

        // Kategori 3 - Permintaan Akun Baru (id = 3)
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 7, // staff Farmasi 2
            'responsible_id' => 3, // staff it 1
            'problem_category_id' => 3,
            'title' => 'Permintaan akun aplikasi stok obat',
            'description' => 'Diperlukan akun baru untuk staf baru bagian Farmasi agar bisa mengakses sistem manajemen stok obat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-03 22:44:06', 
            'updated_at' => '2025-10-03 22:44:06',
            'approved_at' => '2025-10-04 04:11:49', 
            'solved_at' => '2025-10-04 13:55:24'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 1,
            'owner_id' => 22, // staff Gizi 2
            'responsible_id' => 4, // staff it 2
            'problem_category_id' => 3,
            'title' => 'Permintaan akun email resmi untuk staf Gizi',
            'description' => 'Staf baru di bagian Gizi membutuhkan akun email institusi untuk menerima laporan dan jadwal pengiriman bahan makanan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-04 10:56:30', 
            'updated_at' => '2025-10-04 10:56:30',
            'approved_at' => '2025-10-04 12:33:05', 
            'solved_at' => '2025-10-04 13:14:56'
        ]);

        // ============================
        // UNIT FARMASI (id = 2)
        // ============================
        // Kategori 4 - Kekurangan Stok Obat

        Ticket::create([
            'priority_id' => 2,
            'unit_id' => 2,
            'owner_id' => 22, // staff gizi 2
            'problem_category_id' => 4,
            'title' => 'Kekurangan stok obat antibiotik',
            'description' => 'Obat antibiotik jenis amoxicillin dan cefadroxil sudah menipis dan tidak cukup untuk kebutuhan tiga hari ke depan.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 09:02:33',
            'updated_at' => '2025-11-13 09:02:33',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 12, // staff ISPRS 1
            'responsible_id' => 6, // staff Farmasi 1
            'problem_category_id' => 4,
            'title' => 'Stok obat antibiotik hampir habis',
            'description' => 'Unit ISPRS melaporkan bahwa stok antibiotik yang digunakan untuk pasien rawat jalan hampir habis.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-05 07:01:12', 
            'updated_at' => '2025-10-05 07:01:12', 
            'approved_at' => '2025-10-05 11:22:58', 
            'solved_at' => '2025-10-06 09:54:23'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 19, // staff Rumah Tangga 2
            'responsible_id' => 7, // staff farmasi 2
            'problem_category_id' => 4,
            'title' => 'Kekurangan obat penenang di ruang IGD',
            'description' => 'IGD mengalami kekurangan stok obat penenang yang digunakan dalam situasi darurat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-05 23:17:40', 
            'updated_at' => '2025-10-05 23:17:40', 
            'approved_at' => '2025-10-06 06:05:10', 
            'solved_at' => '2025-10-06 09:31:44'
        ]);

        // Kategori 5 - Kesalahan Label Obat
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 10, // staff K3 2
            'responsible_id' => 7, // staff farmasi 2
            'problem_category_id' => 5,
            'title' => 'Label dosis salah pada obat cair anak',
            'description' => 'Label dosis pada obat cair anak menunjukkan takaran yang berbeda dari resep dokter.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-06 08:49:28', 
            'updated_at' => '2025-10-06 08:49:28',
            'approved_at' => '2025-10-06 09:02:41', 
            'solved_at' => '2025-10-06 09:45:22'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 16, // staff CSSD 2
            'responsible_id' => 6, // staff farmasi 1
            'problem_category_id' => 5,
            'title' => 'Obat dengan label kedaluwarsa salah cetak',
            'description' => 'Terdapat obat dengan label kedaluwarsa yang salah cetak di gudang penyimpanan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-06 21:31:09', 
            'updated_at' => '2025-10-06 21:31:09',
            'approved_at' => '2025-10-07 07:54:45', 
            'solved_at' => '2025-10-07 15:28:19'
        ]);

        // Kategori 6 - Pembaruan Data Obat
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 18, // staff Rumah Tangga 1
            'responsible_id' => 6, // staff farmasi 1
            'problem_category_id' => 6,
            'title' => 'Penambahan data obat baru untuk ruang rawat inap',
            'description' => 'Diperlukan pembaruan data obat baru yang mulai digunakan di ruang rawat inap.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-07 09:43:50', 
            'updated_at' => '2025-10-07 09:43:50',
            'approved_at' => '2025-10-07 10:20:17', 
            'solved_at' => '2025-10-07 11:17:03'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 2,
            'owner_id' => 21, // staff Gizi 1
            'responsible_id' => 7, // staff farmasi 2
            'problem_category_id' => 6,
            'title' => 'Perubahan nama dagang pada data obat lama',
            'description' => 'Beberapa obat mengalami perubahan nama dagang dan perlu diperbarui pada sistem.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-07 21:15:56', 
            'updated_at' => '2025-10-07 21:15:56', 
            'approved_at' => '2025-10-08 06:54:21', 
            'solved_at' => '2025-10-08 18:37:29'
        ]);
        // ============================
        // UNIT K3 (id = 3)
        // ============================

        // Kategori 7 - Inspeksi Keselamatan
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 4, // staff IT 2
            'responsible_id' => 9, // staff K3 1
            'problem_category_id' => 7,
            'title' => 'Permintaan inspeksi kabel di ruang server',
            'description' => 'Diperlukan inspeksi keselamatan kabel listrik di ruang server IT karena ditemukan beberapa kabel terbuka dan berpotensi menyebabkan korsleting.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-08 11:02:34',
            'updated_at' => '2025-10-08 11:02:34', 
            'approved_at' => '2025-10-08 13:17:55', 
            'solved_at' => '2025-10-08 15:41:09'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 15, // staff CSSD 1
            'responsible_id' => 10, // staff K3 2
            'problem_category_id' => 7,
            'title' => 'Pemeriksaan alat pemadam api di area sterilisasi',
            'description' => 'Diminta untuk melakukan inspeksi APAR di ruang sterilisasi CSSD karena label pengecekan terakhir sudah melewati batas waktu.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-09 08:55:10', 
            'updated_at' => '2025-10-09 08:55:10', 
            'approved_at' => '2025-10-09 09:45:22', 
            'solved_at' => '2025-10-09 18:03:49'
        ]);

        // Kategori 8 - Pelaporan Kecelakaan Kerja

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 3, // staff it 1
            'problem_category_id' => 8,
            'title' => 'Petugas tersetrum akibat kabel terbuka',
            'description' => 'Salah satu petugas tersetrum ringan di ruang server karena kabel listrik tidak terisolasi dengan baik.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 09:45:27',
            'updated_at' => '2025-11-13 09:45:27',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 7, // staff Farmasi 2
            'responsible_id' => 10, // staff k3 2
            'problem_category_id' => 8,
            'title' => 'Petugas gudang tergores pecahan kaca obat',
            'description' => 'Seorang petugas gudang Farmasi mengalami luka ringan akibat pecahan botol obat yang jatuh. Perlu dicatat sebagai kecelakaan kerja ringan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-09 22:43:01',
            'updated_at' => '2025-10-09 22:43:01', 
            'approved_at' => '2025-10-10 10:14:33', 
            'solved_at' => '2025-10-10 17:02:18'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 19, // staff Rumah Tangga 2
            'responsible_id' => 9, // staff k3 1
            'problem_category_id' => 8,
            'title' => 'Petugas kebersihan terpeleset di koridor IGD',
            'description' => 'Petugas kebersihan tergelincir di area IGD akibat lantai yang licin. Diperlukan tindak lanjut untuk memastikan keselamatan kerja.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-10 09:28:11', 
            'updated_at' => '2025-10-10 09:28:11',
            'approved_at' => '2025-10-10 09:44:27', 
            'solved_at' => '2025-10-10 10:27:53'
        ]);

        // Kategori 9 - Pemeriksaan APD
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 12, // staff ISPRS 1
            'responsible_id' => 10, // staff k3 2
            'problem_category_id' => 9,
            'title' => 'Pemeriksaan APD teknisi belum dilakukan bulan ini',
            'description' => 'Pemeriksaan APD untuk teknisi instalasi listrik belum dilakukan bulan ini, dikhawatirkan ada helm atau sarung tangan yang sudah tidak layak pakai.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-11 07:04:23',
            'updated_at' => '2025-10-11 07:04:23', 
            'approved_at' => '2025-10-11 12:33:14', 
            'solved_at' => '2025-10-11 22:51:36'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 3,
            'owner_id' => 22, // staff Gizi 2
            'responsible_id' => 9, // staff k3 1
            'problem_category_id' => 9,
            'title' => 'Masker medis bagian gizi perlu diperiksa ulang',
            'description' => 'Masker medis yang digunakan staf gizi terlihat sudah aus, diminta pemeriksaan ulang untuk memastikan standar APD terpenuhi.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-11 21:19:18',
            'updated_at' => '2025-10-11 21:19:18', 
            'approved_at' => '2025-10-12 06:12:41', 
            'solved_at' => '2025-10-12 10:33:02'
        ]);

        // ============================
        // UNIT ISPRS (id = 4)
        // ============================

        // Kategori 10 - Kerusakan Instalasi Listrik
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 6, // staff Farmasi 1
            'responsible_id' => 12, // staff ISPRS 1
            'problem_category_id' => 10,
            'title' => 'Lampu di ruang Farmasi mati total',
            'description' => 'Lampu utama di ruang Farmasi tidak menyala meskipun saklar sudah diganti. Perlu pemeriksaan instalasi kabel.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-12 08:49:59', 
            'updated_at' => '2025-10-12 08:49:59', 
            'approved_at' => '2025-10-12 09:22:15', 
            'solved_at' => '2025-10-12 09:55:27'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 9, // staff K3 1
            'responsible_id' => 13, // staff ISPRS 2
            'problem_category_id' => 10,
            'title' => 'Stop kontak di ruang K3 berasap',
            'description' => 'Stop kontak di ruang K3 mengeluarkan asap tipis saat digunakan untuk menyambungkan laptop, perlu diperiksa segera.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-12 23:10:21', 
            'updated_at' => '2025-10-12 23:10:21',
            'approved_at' => '2025-10-13 10:04:42', 
            'solved_at' => '2025-10-13 18:27:39'
        ]);

        // Kategori 11 - Masalah AC dan Ventilasi

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 19, // staff rumah tangga 2
            'problem_category_id' => 11,
            'title' => 'Ventilasi di ruang rekam medis tidak berfungsi',
            'description' => 'Sirkulasi udara di ruang rekam medis kurang baik, menyebabkan ruangan pengap dan lembap.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 10:28:49',
            'updated_at' => '2025-11-13 10:28:49',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 7, // staff Farmasi 2
            'responsible_id' => 13, // staff isprs 2
            'problem_category_id' => 11,
            'title' => 'AC di ruang penyimpanan obat bocor',
            'description' => 'Terdapat kebocoran air dari AC di ruang penyimpanan obat Farmasi yang bisa merusak kemasan obat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-13 08:22:31', 
            'updated_at' => '2025-10-13 08:22:31', 
            'approved_at' => '2025-10-13 09:17:48', 
            'solved_at' => '2025-10-13 09:59:07'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 24, // staff Laundry 1
            'responsible_id' => 12, // staff isprs 1
            'problem_category_id' => 11,
            'title' => 'Ventilasi di ruang jaga petugas tidak berfungsi',
            'description' => 'Ventilasi udara di ruang jaga petugas tidak mengeluarkan udara sama sekali, membuat ruangan pengap dan panas.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-13 21:07:44', 
            'updated_at' => '2025-10-13 21:07:44', 
            'approved_at' => '2025-10-14 06:55:33', 
            'solved_at' => '2025-10-14 20:41:12'
        ]);

        // Kategori 12 - Perawatan Berkala
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 21, // staff Gizi 1
            'responsible_id' => 12, // staff isprs 1
            'problem_category_id' => 12,
            'title' => 'Jadwal servis AC dapur belum dilakukan',
            'description' => 'Servis berkala AC di dapur utama belum dilakukan bulan ini, padahal suhu dapur meningkat drastis akhir-akhir ini.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-14 10:13:06', 
            'updated_at' => '2025-10-14 10:13:06',
            'approved_at' => '2025-10-14 12:02:58', 
            'solved_at' => '2025-10-14 15:44:20'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 4,
            'owner_id' => 15, // staff CSSD 1
            'responsible_id' => 13, // staff isprs 2
            'problem_category_id' => 12,
            'title' => 'Perawatan genset belum dijadwalkan',
            'description' => 'Belum ada jadwal perawatan genset cadangan yang digunakan CSSD selama pemadaman listrik, dikhawatirkan akan macet saat dibutuhkan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-15 09:41:17', 
            'updated_at' => '2025-10-15 09:41:17', 
            'approved_at' => '2025-10-15 12:31:49', 
            'solved_at' => '2025-10-15 21:43:08'
        ]);
        // ============================
        // UNIT CSSD (id = 5)
        // ============================

        // Kategori 13 - Peralatan Steril Hilang
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 18, // staff Rumah Tangga 1
            'responsible_id' => 15, // staff CSSD 1
            'problem_category_id' => 13,
            'title' => 'Peralatan steril dari ruang operasi hilang',
            'description' => 'Beberapa peralatan steril dari ruang operasi dilaporkan hilang setelah proses pembersihan. Diperlukan pengecekan ulang jalur distribusi alat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-15 22:13:30',
            'updated_at' => '2025-10-15 22:13:30',  
            'approved_at' => '2025-10-16 08:17:51', 
            'solved_at' => '2025-10-16 19:55:40'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 21, // staff Gizi 1
            'responsible_id' => 16, // staff CSSD 2
            'problem_category_id' => 13,
            'title' => 'Beberapa nampan makan steril tidak kembali',
            'description' => 'Nampan makan steril yang dipinjam oleh bagian gizi belum dikembalikan, dikhawatirkan terkontaminasi sebelum digunakan lagi.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-16 11:09:28', 
            'updated_at' => '2025-10-16 11:09:28',
            'approved_at' => '2025-10-16 12:21:14', 
            'solved_at' => '2025-10-16 14:42:52'
        ]);

        // Kategori 14 - Autoclave Bermasalah

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 12, // staff isprs 1
            'problem_category_id' => 14,
            'title' => 'Autoclave tidak mencapai suhu sterilisasi',
            'description' => 'Autoclave utama di CSSD tidak mencapai suhu optimal sehingga proses sterilisasi tidak sempurna.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 11:17:55',
            'updated_at' => '2025-11-13 11:17:55',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 13, // staff ISPRS 2
            'responsible_id' => 16, // staff cssd 2
            'problem_category_id' => 14,
            'title' => 'Autoclave tidak mencapai suhu maksimal',
            'description' => 'Autoclave utama di CSSD tidak dapat mencapai suhu maksimal untuk sterilisasi, berpotensi mengganggu jadwal operasi.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-17 07:47:02', 
            'updated_at' => '2025-10-17 07:47:02',
            'approved_at' => '2025-10-17 09:22:19', 
            'solved_at' => '2025-10-17 12:58:50'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 9, // staff K3 1
            'responsible_id' => 15, // staff cssd 1
            'problem_category_id' => 14,
            'title' => 'Alarm tekanan autoclave tidak berfungsi',
            'description' => 'Alarm tekanan pada salah satu autoclave tidak berbunyi saat tekanan mencapai batas maksimal. Hal ini bisa berisiko pada keselamatan kerja.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-17 22:40:11', 
            'updated_at' => '2025-10-17 22:40:11', 
            'approved_at' => '2025-10-18 09:14:43', 
            'solved_at' => '2025-10-18 19:52:36'
        ]);

        // Kategori 15 - Permintaan Sterilisasi Mendesak
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 7, // staff Farmasi 2
            'responsible_id' => 16, // staff cssd 2
            'problem_category_id' => 15,
            'title' => 'Permintaan sterilisasi alat suntik darurat',
            'description' => 'Farmasi membutuhkan sterilisasi cepat untuk alat suntik darurat karena stok alat steril habis.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-18 09:02:30', 
            'updated_at' => '2025-10-18 09:02:30', 
            'approved_at' => '2025-10-18 09:45:18', 
            'solved_at' => '2025-10-18 10:55:33'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 5,
            'owner_id' => 19, // staff Rumah Tangga 2
            'responsible_id' => 15, // staff cssd 1
            'problem_category_id' => 15,
            'title' => 'Permintaan sterilisasi tambahan untuk alat makan pasien',
            'description' => 'Rumah Tangga meminta sterilisasi tambahan untuk alat makan pasien karena permintaan meningkat di ruang rawat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-19 08:14:12', 
            'updated_at' => '2025-10-19 08:14:12', 
            'approved_at' => '2025-10-19 11:37:44', 
            'solved_at' => '2025-10-19 19:22:58'
        ]);

        // ============================
        // UNIT RUMAH TANGGA (id = 6)
        // ============================

        // Kategori 16 - Kebersihan Ruangan
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 15, // staff CSSD 1
            'responsible_id' => 18, // staff Rumah Tangga 1
            'problem_category_id' => 16,
            'title' => 'Ruang sterilisasi perlu dibersihkan ulang',
            'description' => 'Area sterilisasi CSSD terlihat berdebu dan licin setelah proses autoclave. Diminta pembersihan ulang segera.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-19 23:58:31', 
            'updated_at' => '2025-10-19 23:58:31', 
            'approved_at' => '2025-10-20 07:05:10', 
            'solved_at' => '2025-10-20 13:31:22'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 6, // staff Farmasi 1
            'responsible_id' => 19, // staff Rumah Tangga 2
            'problem_category_id' => 16,
            'title' => 'Kebersihan ruang penyimpanan obat kurang terjaga',
            'description' => 'Ruang penyimpanan obat di Farmasi terlihat berdebu dan perlu dibersihkan untuk menjaga higienitas.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-20 09:23:44', 
            'updated_at' => '2025-10-20 09:23:44',
            'approved_at' => '2025-10-20 09:55:03', 
            'solved_at' => '2025-10-20 10:14:29'
        ]);

        // Kategori 17 - Pengelolaan Sampah
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 10, // staff k3 2
            'problem_category_id' => 17,
            'title' => 'Sampah medis tidak terangkut tepat waktu',
            'description' => 'Beberapa kantong sampah medis masih tertinggal di area belakang gedung IGD selama lebih dari 24 jam.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 12:05:31',
            'updated_at' => '2025-11-13 12:05:31',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 9, // staff K3 1
            'responsible_id' => 19, // staff rumah tangga 2
            'problem_category_id' => 17,
            'title' => 'Sampah medis menumpuk di area K3',
            'description' => 'Sampah medis dari ruang pemeriksaan belum diambil sejak kemarin, dikhawatirkan mencemari area kerja.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-21 07:10:58', 
            'updated_at' => '2025-10-21 07:10:58',
            'approved_at' => '2025-10-21 10:21:44', 
            'solved_at' => '2025-10-21 18:42:36'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 22, // staff Gizi 2
            'responsible_id' => 18, // staff rumah tangga 1
            'problem_category_id' => 17,
            'title' => 'Sampah dapur belum diangkut pagi ini',
            'description' => 'Sampah organik dari dapur utama belum diambil oleh petugas kebersihan pagi ini, menyebabkan bau tidak sedap.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-21 22:15:39', 
            'updated_at' => '2025-10-21 22:15:39',
            'approved_at' => '2025-10-22 08:49:10', 
            'solved_at' => '2025-10-22 21:04:51'
        ]);

        // Kategori 18 - Peralatan Kebersihan
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 13, // staff ISPRS 2
            'responsible_id' => 19, // staff rumah tangga 2
            'problem_category_id' => 18,
            'title' => 'Pel lantai di area servis rusak',
            'description' => 'Peralatan pel lantai di area servis ISPRS patah pada gagangnya, membuat proses pembersihan jadi tidak maksimal.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-22 12:43:23', 
            'updated_at' => '2025-10-22 12:43:23',
            'approved_at' => '2025-10-22 13:51:39', 
            'solved_at' => '2025-10-22 14:29:10'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 6,
            'owner_id' => 16, // staff CSSD 2
            'responsible_id' => 18, // staff rumah tangga 1
            'problem_category_id' => 18,
            'title' => 'Permintaan penggantian vacuum cleaner',
            'description' => 'Vacuum cleaner lama di CSSD sudah tidak berfungsi optimal, perlu diganti agar kebersihan ruangan tetap terjaga.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-23 08:07:44',
            'updated_at' => '2025-10-23 08:07:44', 
            'approved_at' => '2025-10-23 09:55:28', 
            'solved_at' => '2025-10-23 13:14:03'
        ]);

        // ============================
        // UNIT GIZI (id = 7)
        // ============================

        // Kategori 19 - Keterlambatan Distribusi Makanan
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 18, // staff Rumah Tangga 1
            'responsible_id' => 21, // staff Gizi 1
            'problem_category_id' => 19,
            'title' => 'Makanan pasien di ruang isolasi terlambat datang',
            'description' => 'Rumah Tangga melaporkan bahwa makanan pasien di ruang isolasi sering terlambat dikirim oleh bagian gizi.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-23 22:19:55', 
            'updated_at' => '2025-10-23 22:19:55',
            'approved_at' => '2025-10-24 07:43:37', 
            'solved_at' => '2025-10-24 18:26:09'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 3, // staff IT 1
            'responsible_id' => 22, // staff Gizi 2
            'problem_category_id' => 19,
            'title' => 'Makanan staf IT tidak dikirim sesuai jadwal',
            'description' => 'Makanan siang staf IT sering datang terlambat, mengganggu waktu kerja saat jadwal padat.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-24 11:17:03', 
            'updated_at' => '2025-10-24 11:17:03', 
            'approved_at' => '2025-10-24 11:59:44', 
            'solved_at' => '2025-10-24 12:37:52'
        ]);

        // Kategori 20 - Menu Tidak Sesuai Diet
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 13, // staff isprs 2
            'problem_category_id' => 19,
            'title' => 'Menu pasien diabetes tidak sesuai standar',
            'description' => 'Menu makan untuk pasien diabetes mengandung kadar gula tinggi, berpotensi mengganggu kondisi pasien.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 13:44:12',
            'updated_at' => '2025-11-13 13:44:12',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 6, // staff Farmasi 1
            'responsible_id' => 21, // staff gizi 1
            'problem_category_id' => 20,
            'title' => 'Pasien diabetes menerima menu tinggi gula',
            'description' => 'Ditemukan kesalahan menu untuk pasien diabetes yang justru mengandung kadar gula tinggi, perlu koreksi segera.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-25 07:28:39', 
            'updated_at' => '2025-10-25 07:28:39',
            'approved_at' => '2025-10-25 10:42:15', 
            'solved_at' => '2025-10-25 19:11:08'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 25, // staff laundry 2
            'responsible_id' => 22, // staff gizi 2
            'problem_category_id' => 20,
            'title' => 'Menu staf malam tidak sesuai standar gizi',
            'description' => 'Makanan untuk staf jaga malam tidak mengandung cukup karbohidrat dan protein, mohon diperbaiki sesuai standar.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-25 23:10:02', 
            'updated_at' => '2025-10-25 23:10:02', 
            'approved_at' => '2025-10-26 08:01:19', 
            'solved_at' => '2025-10-26 17:44:50'
        ]);

        // Kategori 21 - Kualitas Bahan Makanan
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 15, // staff CSSD 1
            'responsible_id' => 22, // staff gizi 2
            'problem_category_id' => 21,
            'title' => 'Sayur untuk makan siang terasa basi',
            'description' => 'Sayur yang dikirim untuk makan siang staf CSSD sudah tidak segar dan berbau, perlu dicek pemasok bahan makanan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-26 09:32:27', 
            'updated_at' => '2025-10-26 09:32:27', 
            'approved_at' => '2025-10-26 09:52:13', 
            'solved_at' => '2025-10-26 10:09:45'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 7,
            'owner_id' => 13, // staff ISPRS 2
            'responsible_id' => 21, // staff gizi 1
            'problem_category_id' => 21,
            'title' => 'Kualitas nasi menurun dalam beberapa hari terakhir',
            'description' => 'Nasi yang dikirim ke ruang ISPRS terasa keras dan cepat basi, mohon evaluasi kualitas beras yang digunakan.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-27 08:11:40', 
            'updated_at' => '2025-10-27 08:11:40',
            'approved_at' => '2025-10-27 09:47:29', 
            'solved_at' => '2025-10-27 12:04:55'
        ]);

        // ============================
        // UNIT LAUNDRY (id = 8)
        // ============================

        // Kategori 22 - Linen Kotor Tidak Diambil
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 7, // staff Farmasi 2
            'responsible_id' => 25, // staff Laundry 2
            'problem_category_id' => 22,
            'title' => 'Linen ruang Farmasi belum diambil dua hari',
            'description' => 'Linen bekas di ruang Farmasi belum diambil oleh bagian laundry selama dua hari, menyebabkan bau tidak sedap.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-27 22:44:11', 
            'updated_at' => '2025-10-27 22:44:11',
            'approved_at' => '2025-10-28 09:30:03', 
            'solved_at' => '2025-10-28 20:22:18'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 16, // staff CSSD 2
            'responsible_id' => 24, // staff laundry 1
            'problem_category_id' => 22,
            'title' => 'Linen kotor dari ruang sterilisasi belum diangkut',
            'description' => 'Linen bekas sterilisasi belum diambil dari CSSD sejak pagi, padahal area tersebut membutuhkan kebersihan maksimal.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-28 11:05:14', 
            'updated_at' => '2025-10-28 11:05:14', 
            'approved_at' => '2025-10-28 12:42:29', 
            'solved_at' => '2025-10-28 13:55:38'
        ]);

        // Kategori 23 - Linen Hilang atau Tertukar
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 16, // staff CSSD 2
            'problem_category_id' => 23,
            'title' => 'Kekurangan linen steril untuk ruang operasi',
            'description' => 'Stok linen steril menipis dan belum ada pengiriman tambahan sejak pagi, dikhawatirkan menghambat jadwal operasi.',
            'ticket_statuses_id' => 1,
            'created_at' => '2025-11-13 13:15:00',
            'updated_at' => '2025-11-13 13:15:00',
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 21, // staff Gizi 1
            'responsible_id' => 24, // staff laundry 1
            'problem_category_id' => 23,
            'title' => 'Linen dapur tertukar dengan ruang operasi',
            'description' => 'Beberapa linen dapur ditemukan memiliki label ruang operasi, kemungkinan tertukar saat proses pengantaran.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-29 08:23:51', 
            'updated_at' => '2025-10-29 08:23:51',
            'approved_at' => '2025-10-29 10:45:03', 
            'solved_at' => '2025-10-29 19:22:31'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 18, // staff Rumah Tangga 1
            'responsible_id' => 25, // staff laundry 2
            'problem_category_id' => 23,
            'title' => 'Linen kebersihan hilang setelah pencucian',
            'description' => 'Satu set linen kebersihan hilang setelah proses pencucian, mohon dilakukan pengecekan ulang di area laundry.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-29 22:55:44', 
            'updated_at' => '2025-10-29 22:55:44',
            'approved_at' => '2025-10-30 09:08:10', 
            'solved_at' => '2025-10-30 17:41:26'
        ]);

        // Kategori 24 - Kualitas Cuci Buruk
        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 10, // staff K3 2
            'responsible_id' => 25, // staff laundry 2
            'problem_category_id' => 24,
            'title' => 'Linen hasil cuci masih berbau bahan kimia',
            'description' => 'Linen yang diterima oleh bagian K3 masih berbau bahan kimia kuat setelah dicuci, mohon perbaikan proses bilas.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-30 09:55:03',
            'updated_at' => '2025-10-30 09:55:03',  
            'approved_at' => '2025-10-30 10:33:17', 
            'solved_at' => '2025-10-30 11:02:49'
        ]);

        Ticket::create([
            'priority_id' => 1,
            'unit_id' => 8,
            'owner_id' => 19, // staff Rumah Tangga 2
            'responsible_id' => 24, // staff laundry 1
            'problem_category_id' => 24,
            'title' => 'Linen kamar pasien masih terasa lembap',
            'description' => 'Beberapa linen kamar pasien masih lembap saat dikirim, kemungkinan proses pengeringan kurang optimal.',
            'ticket_statuses_id' => 6,
            'created_at' => '2025-10-31 08:14:29', 
            'updated_at' => '2025-10-31 08:14:29', 
            'approved_at' => '2025-10-31 10:48:36', 
            'solved_at' => '2025-10-31 16:33:22'
        ]);
    }
}