# Integrasi Telegram dengan Helpdesk Laravel (Lokal)

Dokumen ini menjelaskan cara mengkonfigurasi integrasi Telegram untuk mengirim notifikasi dari aplikasi Helpdesk Laravel yang berjalan di lingkungan pengembangan lokal menggunakan `ngrok` sebagai tunnel.

## Prasyarat

1.  **Akun Telegram & Bot:** Anda harus memiliki bot Telegram dan token botnya. Jika belum, buat bot baru dengan berbicara kepada [@BotFather](https://t.me/BotFather) di Telegram.
2.  **Ngrok:** Pastikan `ngrok` sudah terinstal di sistem Anda. Anda bisa mengunduhnya dari [ngrok.com](https://ngrok.com/download).
3.  **ID Grup Telegram:** Anda memerlukan ID grup target tempat notifikasi akan dikirim. Anda bisa mendapatkan ID ini dengan menambahkan bot ke grup dan menggunakan bot seperti `@RawDataBot` untuk melihat ID grup (biasanya angka negatif).

## Langkah-langkah Konfigurasi

### 1. Konfigurasi File `.env`

Salin file `.env.example` menjadi `.env` jika Anda belum memilikinya:

```bash
cp .env.example .env
```

Buka file `.env` dan isi variabel berikut:

-   `TELEGRAM_BOT_TOKEN`: Isi dengan token bot yang Anda dapatkan dari BotFather.
    -   Contoh untuk bot Anda: `TELEGRAM_BOT_TOKEN=`
-   `TELEGRAM_WEBHOOK_URL`: Ini akan menjadi URL publik yang dibuat oleh `ngrok`. Biarkan kosong untuk saat ini.

### 2. Jalankan Server Lokal dan Ngrok

1.  Buka terminal dan jalankan server pengembangan Laravel:

    ```bash
    php artisan serve
    ```

    Secara default, server akan berjalan di `http://127.0.0.1:8000`.

2.  Buka terminal **lain** dan jalankan `ngrok` untuk membuat tunnel ke server lokal Anda:

    ```bash
    ngrok http 8000
    ```

3.  `ngrok` akan memberikan Anda URL publik. Untuk kasus Anda, URL-nya adalah `https://experienceable-briggs-unreasoning.ngrok-free.dev`. Salin URL **HTTPS** ini.

### 3. Atur Webhook URL

1.  Kembali ke file `.env` Anda dan tempelkan URL `ngrok` yang telah Anda salin ke variabel `TELEGRAM_WEBHOOK_URL`.

    ```env
    TELEGRAM_WEBHOOK_URL=https://experienceable-briggs-unreasoning.ngrok-free.dev/telegram/webhook
    ```

    **Penting:** Pastikan untuk menambahkan `/telegram/webhook` di akhir URL `ngrok` Anda. Ini adalah endpoint yang akan mendengarkan pembaruan dari Telegram.

2.  Jalankan perintah `artisan` untuk mendaftarkan URL webhook ini ke Telegram:

    ```bash
    php artisan telegram:set-webhook
    ```

    Jika berhasil, Anda akan melihat pesan sukses.

### 4. Konfigurasi Notifikasi

Pastikan `Unit` yang relevan di database Anda memiliki `telegram_group_id` yang benar. Untuk grup Anda, ID-nya adalah `-4890970835`. Ini akan memastikan notifikasi dapat dikirim ke grup yang sesuai saat tiket dibuat untuk unit tersebut.

## Bagaimana Cara Kerjanya?

-   **Ngrok:** Meneruskan permintaan dari internet publik ke server lokal Anda.
-   **Webhook:** Setiap kali ada aktivitas yang relevan (misalnya, pesan ke bot), Telegram akan mengirimkan data ke URL `ngrok` Anda.
-   **Route (`routes/web.php`):** Rute `/telegram/webhook` menangkap data ini.
-   **Event & Listener:** Ketika tiket baru dibuat (`TicketCreated` event), `SendTelegramNotification` listener akan terpicu. Listener ini menggunakan `TelegramService` untuk mengirim pesan notifikasi ke ID grup yang terkait dengan unit tiket.

Dengan mengikuti langkah-langkah ini, Anda dapat sepenuhnya menguji alur notifikasi Telegram di lingkungan pengembangan lokal Anda.