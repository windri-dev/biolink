# BioLink — Modern Link-in-Bio Platform with AI Assistant 🚀

[![PHP Version](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777bb4?logo=php)](https://php.net)
[![Laravel Framework](https://img.shields.io/badge/Laravel-11%20%7C%2012-FF2D20?logo=laravel)](https://laravel.com)
[![Database](https://img.shields.io/badge/Database-MySQL%20%7C%20MariaDB-4479A1?logo=mysql)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-v3-38bdf8?logo=tailwindcss)](https://tailwindcss.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**BioLink** adalah aplikasi *link-in-bio* (replika resmi terinspirasi dari [bio.link](https://bio.link/)) yang dibangun menggunakan **Full Laravel Versi Terbaru**, database relasional **MySQL**, antarmuka responsif **Tailwind CSS**, dan dilengkapi dengan **Asisten AI Interaktif** (*Floating AI Assistant*).

Aplikasi ini dirancang khusus untuk kebutuhan personal branding developer, kreator, dan bisnis yang menginginkan kemandirian penuh (*self-hosted*), performa super cepat, kontrol data mutlak tanpa biaya langganan bulanan (*zero monthly fee*), serta kemudahan perawatan (*maintainability*).

---

## ✨ Fitur-Fitur Utama

### 1. Halaman Publik Pengunjung (*Public Bio Page*)
* **Mobile-First & Clean Aesthetic**: Desain minimalis mewah (*Dark Luxury*) yang presisi di layar smartphone maupun desktop.
* **Identitas & Lencana Resmi**: Foto profil avatar melingkar, nama tampilan, handle unik (`/@windri`), status terverifikasi (*verified badge* centang biru), profesi, dan lokasi domisili.
* **Kanal Media Sosial**: Barisan ikon media sosial resmi (GitHub, Telegram, WhatsApp, Email, YouTube, X/Twitter, LinkedIn, Situs Web) dengan animasi hover dinamis.
* **Kartu Tautan Fleksibel (*Bio Links*)**:
  - Tombol tautan dengan ikon kustom, subjudul deskriptif, dan lencana status (*NEW*, *HOT*, *OFFICIAL*, *LIVE DEMO*).
  - Pilihan animasi sorotan halus (*subtle pulse / glow*).
  - Pemisah kategori (*Header divider*).
  - Media embed (Video YouTube responsif).
* **Pelacakan Klik 1-Klik**: Setiap klik tautan diarahkan melalui endpoint pelacak `/l/{id}` untuk mencatat metrik tanpa mengorbankan kecepatan navigasi pengunjung.
* **Tombol Bagikan Cepat (*Share Button*)**: Mendukung *Web Share API* bawaan browser ponsel dan tombol salin URL ke clipboard.

### 2. Asisten AI Interaktif (*Floating AI Widget*) 🤖
* **Widget Mengambang Cerdas**: Tombol AI melayang di pojok kanan bawah dengan lencana status *online* yang dapat diperbesar menjadi jendela obrolan *glassmorphic*.
* **Basis Pengetahuan Terintegrasi (*Knowledge Engine*)**: Asisten AI menjawab pertanyaan pengunjung (tentang profil diri, proyek unggulan, kontak kolaborasi, dan tech stack) secara akurat berdasarkan data di database.
* **Typewriter Effect & Chip Saran**: Menghadirkan efek ketik kata-per-kata yang natural disertai tombol saran pertanyaan cepat (*prompt chips*).
* **Dukungan Dual-Engine**: Berfungsi mandiri secara offline/lokal menggunakan algoritma pencocokan kata kunci, dan dapat disambungkan ke OpenAI API (`gpt-4o-mini`) via file `.env`.

### 3. Studio Dasbor Pengelola (*Admin Studio Dashboard*)
* **Ringkasan Analitik**: Total tayangan profil, total klik tautan, rasio konversi klik (*Click-Through Rate*), dan grafik tren kunjungan 7 hari terakhir.
* **Manajemen Tautan (*Links Manager*)**: Tambah tautan baru, ubah urutan (*sort order*), edit teks/lencana/warna, dan sakelar instan aktif/nonaktifkan tautan tanpa menghapusnya.
* **Pengaturan Profil & Medsos**: Perbarui nama, username publik, bio, unggah foto avatar langsung dengan pratinjau instan, dan konfigurasi tautan medsos.
* **Koleksi Tema Visual (*Theme Studio*)**:
  - **6 Preset Tema Siap Pakai**: *Dark Luxury (Default)*, *Midnight Indigo*, *Emerald Glass*, *Minimalist Cream (Light Mode)*, *Cyberpunk Neon*, dan *Sunset Aura*.
  - **Pembuat Tema Kustom**: Buat gradien latar belakang, warna kartu, aksen tombol, dan bentuk sudut sendiri.
* **Otak Pengetahuan AI (*AI Brain Manager*)**: Tambah fakta, FAQ, kata kunci pemicu, serta simulator pengujian respon AI secara langsung (*Sandbox Test*).
* **Log & Statistik Lengkap**: Riwayat log 10 percakapan pengunjung dengan AI, rincian klik per tautan, serta distribusi perangkat pengunjung (*Mobile vs Desktop vs Tablet*).

---

## 🏗️ Struktur Arsitektur & Database

Aplikasi menggunakan skema database MySQL yang bersih, ternormalisasi, dan telah diindeks untuk kecepatan kueri maksimal:

```
├── users                  # Autentikasi akun admin
├── profiles               # Informasi profil bio, metadata SEO, status AI, dan tema aktif
├── themes                 # Preset tema visual & tema kustom (CSS background, warna, bentuk tombol)
├── social_links           # Kanal media sosial terurut per profil
├── bio_links              # Daftar tautan, pembatas header, dan embed video
├── ai_knowledges          # Basis data pengetahuan untuk asisten AI (kategori, fakta, chip saran)
├── page_views             # Log riwayat kunjungan halaman (IP, User-Agent, perangkat, referer)
├── link_clicks            # Log pelacakan klik per tautan
└── ai_chats               # Log percakapan pengunjung dengan AI Assistant
```

---

## 💻 Panduan Instalasi di Lingkungan Lokal (Local Development)

Ikuti langkah-langkah mudah berikut untuk menjalankan proyek di komputer/laptop lokal Anda:

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
*(Pastikan Anda telah membuat database kosong bernama `biolink_db` di phpMyAdmin, MySQL CLI, atau DBeaver).*

### 5. Jalankan Migrasi & Seeder Awal
Perintah ini akan membuat seluruh tabel di MySQL dan mengisi data profil awal, 6 tema preset, contoh tautan, dan basis pengetahuan AI:
```bash
php artisan migrate --seed
```

### 6. Tautkan Direktori Penyimpanan Aset (Storage Link)
Untuk mendukung penyimpanan foto profil/avatar yang diunggah dari dashboard:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```

Aplikasi Anda kini aktif di: **`http://localhost:8000`** 🎉

---

## 🔑 Kredensial Masuk Admin Studio

Setelah menjalankan seeder database, gunakan akun bawaan berikut untuk masuk ke dashboard admin:

* **URL Dasbor Admin**: [http://localhost:8000/admin/login](http://localhost:8000/admin/login)
* **Email**: `admin@biolink.local`
* **Password**: `password123`

*(Anda dapat mengganti email dan kata sandi kapan saja melalui pengaturan profil di dalam dashboard).*

---

## 🌐 Rute-Rute Utama Aplikasi

| Rute URL | Metode | Deskripsi |
|---|---|---|
| `/` | `GET` | Halaman bio publik utama (otomatis memuat profil aktif) |
| `/@{handle}` | `GET` | Halaman bio publik berdasarkan username (misal: `/@windri`) |
| `/l/{id}` | `GET` | URL pengalihan pelacakan klik tautan resmi |
| `/api/ai-chat` | `POST` | Endpoint komunikasi widget obrolan AI |
| `/admin/login` | `GET / POST` | Halaman masuk pengelola admin studio |
| `/admin/dashboard` | `GET` | Halaman ringkasan metrik & analitik |
| `/admin/links` | `GET / POST / PUT` | Manajemen kartu tautan & embed |
| `/admin/profile` | `GET / POST` | Pengaturan data profil dan akun media sosial |
| `/admin/themes` | `GET / POST` | Galeri tema visual & pembuatan tema kustom |
| `/admin/ai-knowledge` | `GET / POST / PUT` | Manajemen basis pengetahuan AI & sandbox simulator |
| `/admin/analytics` | `GET` | Rincian lengkap analitik pengunjung dan log obrolan |

---

## 🛠️ Tips Pemeliharaan (*Maintenance*)

1. **Menambah Jawaban Baru untuk Asisten AI**:
   - Masuk ke dashboard admin &rarr; menu **Otak AI Assistant** &rarr; klik **Tambah Data Pengetahuan**.
   - Masukkan judul, kategori, kata kunci pemicu, dan isi jawaban.
   - Uji coba langsung menggunakan **Simulator Sandbox** di bagian atas menu.
2. **Mengubah Tema Warna Profil**:
   - Masuk ke menu **Tema & Tampilan** &rarr; klik tombol **Terapkan Tema Ini** pada salah satu dari 6 tema preset yang tersedia, atau rancang tema sendiri melalui tombol **Buat Tema Kustom**.
3. **Mengaktifkan OpenAI LLM (Opsional)**:
   - Jika Anda ingin asisten AI menggunakan model bahasa besar OpenAI saat kata kunci tidak ditemukan, cukup tambahkan kunci API Anda di file `.env`:
     ```env
     OPENAI_API_KEY=sk-proj-...
     OPENAI_MODEL=gpt-4o-mini
     ```

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi terbuka [MIT License](LICENSE). Bebas digunakan, dimodifikasi, dan dikembangkan secara mandiri.
Dikelola dengan bangga oleh [@windri-dev](https://github.com/windri-dev).
