# Dokumentasi Tunneling Lokal dengan Cloudflare Tunnel

Dokumen ini menjelaskan cara mengekspos server aplikasi lokal Anda (misalnya, yang berjalan pada `localhost:8000`) ke internet menggunakan Cloudflare Tunnel. Ini sangat berguna untuk melakukan testing webhook, seperti webhook dari Telegram Bot. Metode yang digunakan adalah "Quick Tunnel" yang tidak memerlukan konfigurasi domain.

## Langkah 1: Instalasi `cloudflared`

`cloudflared` adalah _command-line tool_ yang digunakan untuk menjalankan Cloudflare Tunnel. Cara instalasinya berbeda-beda tergantung sistem operasi Anda.

### macOS
Gunakan Homebrew untuk instalasi yang mudah:
```bash
brew install cloudflare/cloudflare/cloudflared
```

### Windows
Anda bisa mengunduh `cloudflared.exe` dari [halaman rilis Cloudflare](https://github.com/cloudflare/cloudflared/releases/latest). Setelah diunduh, tempatkan di direktori yang bisa diakses melalui PATH Anda, atau jalankan langsung dari lokasi unduhan.

### Linux (Debian/Ubuntu)
```bash
wget -q https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb
sudo dpkg -i cloudflared-linux-amd64.deb
```

Untuk sistem operasi lain, silakan merujuk ke [dokumentasi instalasi resmi](https://developers.cloudflare.com/cloudflare-one/connections/connect-apps/install-and-setup/installation/).

## Langkah 2: Jalankan Server Aplikasi Lokal Anda

Sebelum membuat tunnel, pastikan server aplikasi Laravel Anda sudah berjalan. Biasanya, ini dilakukan dengan perintah:
```bash
php artisan serve
```
Perintah ini akan menjalankan server pada `http://127.0.0.1:8000` atau `http://localhost:8000`. Catat alamat dan port ini.

## Langkah 3: Jalankan Cloudflare Tunnel

Buka terminal baru (biarkan terminal server lokal tetap berjalan) dan jalankan perintah berikut. Ganti port `8000` jika server Anda berjalan di port yang berbeda.

```bash
cloudflared tunnel --url http://localhost:8000
```

## Langkah 4: Gunakan URL Publik Anda

Setelah perintah di atas dijalankan, `cloudflared` akan menampilkan output yang berisi URL publik acak yang mengarah ke server lokal Anda. Contoh outputnya akan terlihat seperti ini:

```
2023-10-27T10:00:00Z INF |  Your tunnel has been established at https://your-random-subdomain.trycloudflare.com and is serving traffic from http://localhost:8000
```

URL `https://your-random-subdomain.trycloudflare.com` adalah alamat publik Anda. Anda bisa menggunakan URL ini untuk:
- Mengatur webhook Telegram Bot.
- Mengakses aplikasi Anda dari perangkat lain untuk testing.
- Membagikannya kepada rekan tim untuk demonstrasi.

Tunnel akan tetap aktif selama jendela terminal tempat Anda menjalankan perintah `cloudflared` tetap terbuka. Untuk menghentikan tunnel, cukup tutup terminal tersebut atau tekan `Ctrl + C`.
