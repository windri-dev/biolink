# BioLink — Multi-User Link-in-Bio & Creator Platform with AI Assistant 🚀

[![PHP Version](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777bb4?logo=php)](https://php.net)
[![Laravel Framework](https://img.shields.io/badge/Laravel-11%20%7C%2012-FF2D20?logo=laravel)](https://laravel.com)
[![Database](https://img.shields.io/badge/Database-MySQL%20%7C%20MariaDB-4479A1?logo=mysql)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-v3-38bdf8?logo=tailwindcss)](https://tailwindcss.com)
[![Multi-User](https://img.shields.io/badge/Multi--User-SaaS%20Ready-emerald)](https://github.com/windri-dev/biolink)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**BioLink** adalah platform *link-in-bio* **Multi-User (SaaS-Ready)** — replika lengkap terinspirasi dari [bio.link](https://bio.link/) yang dibangun menggunakan **Full Laravel Versi Terbaru**, database relasional **MySQL**, antarmuka responsif **Tailwind CSS**, dan dilengkapi dengan **Asisten AI Pintar** (*Floating AI Assistant*) pada setiap profil pengguna.

Platform ini tidak hanya dapat digunakan untuk satu orang, melainkan dapat digunakan oleh **banyak orang / publik**:
* Siapa saja dapat mendaftar melalui halaman registrasi (`/register`) atau mengklaim username di beranda (`/@username`).
* Setiap pengguna mendapatkan halaman bio mandiri (`/@username` atau `/username`).
* Setiap pengguna memiliki **Studio Dasbor Admin terisolasi** untuk mengatur profil, tautan, tema, basis pengetahuan AI, dan analitik mereka sendiri.

---

## ✨ Fitur-Fitur Utama Platform

### 1. Halaman Depan & Pendaftaran Multi-User (*SaaS Landing Page*)
* **Beranda Modern (*bio.link Parity*)**: Dilengkapi formulir interaktif *Claim Your Link* (`biolink.local/@yourname`), showcase fitur, dan pratinjau tema langsung.
* **Sistem Registrasi Mandiri (`/register`)**: Pengecekan keunikan handle/username secara otomatis, proteksi username sistem terlarang (*reserved keywords*), dan pembuatan profil instan dengan tema default.
* **Sistem Autentikasi (`/login` & `/logout`)**: Autentikasi sesi aman berbasis Laravel dengan proteksi remember token.

### 2. Halaman Bio Publik Tiap Pengguna (`/@handle` & `/{handle}`)
* **Mobile-First & Clean Aesthetic**: Desain responsif super cepat yang memuat profil unik masing-masing pengguna.
* **Identitas & Lencana Resmi**: Foto profil avatar, nama tampilan, handle unik (`/@budi`), verified badge centang biru, profesi, dan lokasi domisili.
* **Kanal Media Sosial**: Barisan ikon media sosial resmi (GitHub, Telegram, WhatsApp, Email, YouTube, X/Twitter, LinkedIn, Situs Web) dengan animasi hover.
* **Kartu Tautan Dinamis (*Bio Links*)**:
  - Tombol tautan dengan ikon kustom, subjudul, dan lencana status (*NEW*, *HOT*, *OFFICIAL*, *LIVE DEMO*).
  - Pilihan animasi sorotan halus (*subtle pulse / glow*).
  - Pembatas kategori (*Header divider*) dan Embed Video YouTube responsif.
* **Pelacakan Klik 1-Klik**: Setiap klik tautan diarahkan melalui endpoint pelacak `/l/{id}` untuk mencatat metrik klik per pengguna.
* **Tombol Bagikan Cepat (*Share Button*)**: Mendukung *Web Share API* bawaan smartphone dan tombol salin link profil ke clipboard.

### 3. Asisten AI Interaktif (*Floating AI Widget*) 🤖
* **Widget Mengambang pada Setiap Bio**: Tombol AI melayang di pojok kanan bawah dengan lencana status *online* yang dapat diperbesar menjadi jendela obrolan *glassmorphic*.
* **Basis Pengetahuan Spesifik Pengguna (*Isolated Knowledge Engine*)**: Asisten AI menjawab pertanyaan pengunjung (tentang profil diri, portofolio, kontak kolaborasi) secara akurat berdasarkan basis pengetahuan yang diisi oleh masing-masing pemilik profil di dashboard mereka.
* **Typewriter Effect & Chip Saran**: Efek ketik kata-per-kata yang natural disertai tombol saran pertanyaan cepat (*prompt chips*).
* **Dukungan Dual-Engine**: Berfungsi mandiri secara offline/lokal menggunakan algoritma pencocokan kata kunci, dan dapat disambungkan ke OpenAI API (`gpt-4o-mini`) via file `.env`.

### 4. Studio Dasbor Pengelola Mandiri (*Multi-Tenant User Studio*)
Setiap pengguna yang masuk ke dasbor `/admin` hanya dapat mengelola data profil mereka sendiri:
* **Ringkasan Analitik**: Total tayangan profil, total klik tautan, rasio konversi klik (*Click-Through Rate*), dan grafik tren kunjungan 7 hari terakhir.
* **Manajemen Tautan (*Links Manager*)**: Tambah tautan baru, ubah urutan (*sort order*), edit badge/warna, dan sakelar instan aktif/nonaktifkan tautan tanpa menghapusnya.
* **Pengaturan Profil & Medsos**: Perbarui nama, handle unik, bio, unggah foto avatar langsung dengan pratinjau instan, dan konfigurasi tautan medsos.
* **Koleksi Tema Visual (*Theme Studio*)**:
  - **6 Preset Tema Siap Pakai**: *Dark Luxury (Default)*, *Midnight Indigo*, *Emerald Glass*, *Minimalist Cream (Light Mode)*, *Cyberpunk Neon*, dan *Sunset Aura*.
  - **Pembuat Tema Kustom**: Buat gradien latar belakang, warna kartu, aksen tombol, dan bentuk sudut sendiri.
* **Otak Pengetahuan AI (*AI Brain Manager*)**: Tambah fakta, FAQ, kata kunci pemicu, serta simulator pengujian respon AI secara langsung (*Sandbox Test*).
* **Log & Statistik Lengkap**: Rincian klik per tautan, distribusi perangkat (*mobile/desktop*), dan 10 riwayat percakapan AI terbaru.

---

## 🏗️ Struktur Arsitektur & Database

Aplikasi menggunakan skema database MySQL yang terisolasi per akun pengguna (*multi-tenant* via `profile_id` & `user_id`):

```
├── users                  # Data akun pengguna (nama, email, sandi)
├── profiles               # Informasi profil bio per pengguna (handle unik, avatar, bio, tema)
├── themes                 # Preset tema visual & tema kustom pengguna
├── social_links           # Kanal media sosial terurut per profil
├── bio_links              # Daftar tautan, pembatas header, dan embed video per profil
├── ai_knowledges          # Basis data pengetahuan untuk asisten AI per profil
├── page_views             # Log riwayat kunjungan halaman (IP, User-Agent, perangkat, referer)
├── link_clicks            # Log pelacakan klik per tautan
└── ai_chats               # Log percakapan pengunjung dengan AI Assistant per profil
```

---

## 💻 Panduan Menjalankan di Komputer Lokal (Local Development)

### 1. Kloning Repositori
```bash
git clone https://github.com/windri-dev/biolink.git
cd biolink
```

### 2. Pasang Dependensi PHP (Composer)
```bash
composer install
```

### 3. Salin Konfigurasi Environment & Buat Kunci Aplikasi
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database MySQL di File `.env`
Buka file `.env`, lalu sesuaikan kredensial MySQL lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biolink_db
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda telah membuat database kosong bernama `biolink_db` di phpMyAdmin, MySQL Workbench, atau DBeaver).*

### 5. Jalankan Migrasi & Seeder Awal
Perintah ini akan membuat seluruh tabel di MySQL dan mengisi data profil awal, 6 tema preset, contoh tautan, dan basis pengetahuan AI:
```bash
php artisan migrate --seed
```

### 6. Tautkan Direktori Penyimpanan Aset (Storage Link)
Untuk mendukung penyimpanan foto avatar yang diunggah dari dashboard:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```

Aplikasi Anda kini aktif di: **`http://localhost:8000`** 🎉

---

## 🌐 Alur Penggunaan Multi-User

1. **Pengunjung Umum**:
   - Membuka `http://localhost:8000` untuk melihat halaman beranda SaaS.
   - Mengetik username yang diinginkan di kolom *biolink.local/@username* lalu klik **Klaim Tautan**.
   - Mengisi formulir pendaftaran di `/register`.
2. **Setelah Mendaftar**:
   - Akun langsung otomatis login dan diarahkan ke Studio Dasbor `/admin/dashboard`.
   - Pengguna dapat menambahkan link portofolio mereka sendiri, memilih tema kesukaan, dan melatih asisten AI mereka.
   - Halaman bio publik mereka langsung aktif di `http://localhost:8000/@username`.
3. **Melihat Profil Pengguna Lain**:
   - Profil Windri (bawaan seeder): `http://localhost:8000/@windri`
   - Profil pengguna baru (misal Budi): `http://localhost:8000/@budi`

---

## 🔑 Akun Bawaan Seeder (Untuk Testing Instan)

* **URL Dasbor**: [http://localhost:8000/login](http://localhost:8000/login)
* **Email**: `admin@biolink.local`
* **Password**: `password123`
* **URL Bio Publik**: [http://localhost:8000/@windri](http://localhost:8000/@windri)

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi terbuka [MIT License](LICENSE). Bebas digunakan, dimodifikasi, dan dikembangkan secara mandiri.
Dikelola dengan bangga oleh [@windri-dev](https://github.com/windri-dev).
