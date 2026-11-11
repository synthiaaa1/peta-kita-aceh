# 📋 Panduan Setup PetaKita Aceh — Untuk Anggota Tim

Panduan ini untuk teman-teman tim yang baru clone repo dan ingin menjalankan proyek di laptop masing-masing.

---

## ✅ Prasyarat — Install Dulu

Sebelum mulai, pastikan laptop kamu sudah ada:

| Software | Versi | Download |
|----------|-------|----------|
| **PHP** | 8.2+ | https://www.php.net/downloads |
| **Composer** | terbaru | https://getcomposer.org/download/ |
| **Node.js** | 18+ | https://nodejs.org |
| **Git** | terbaru | https://git-scm.com/downloads |
| **PostgreSQL** | 15/16/17 | https://www.postgresql.org/download/windows/ |
| **PostGIS** | (via Stack Builder) | Install saat/setelah install PostgreSQL |

> ⚠️ **Saat install PostgreSQL**, catat password yang kamu buat untuk user `postgres`. Jangan lupa!

---

## 🚀 Langkah Setup (Ikuti Urutan Ini!)

### 1. Clone Repository

Buka PowerShell, lalu ketik:

```powershell
git clone https://github.com/synthiaaa1/peta-kita-aceh.git
cd peta-kita-aceh
cd peta-kita-aceh
```

> ⚠️ Masuk ke folder `peta-kita-aceh` **dua kali** ya (ada subfolder)

---

### 2. Install Dependency PHP

```powershell
composer install
```

> Tunggu sampai selesai, bisa 2-5 menit

---

### 3. Install Dependency JavaScript

```powershell
npm install
```

---

### 4. Buat File `.env`

```powershell
copy .env.example .env
php artisan key:generate
```

---

### 5. Setting Database di `.env`

Buka file `.env` di VS Code, cari bagian ini dan isi sesuai PostgreSQL kamu:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=satu_peta_aceh
DB_USERNAME=postgres
DB_PASSWORD=isi_password_postgresql_kamu_disini
```

---

### 6. Buat Database di pgAdmin

1. Buka **pgAdmin 4** (ada di Start Menu)
2. Login dengan password PostgreSQL kamu
3. Klik kanan **Databases** → **Create** → **Database**
4. Isi nama: `satu_peta_aceh`
5. Klik **Save**

---

### 7. Jalankan Migrasi Database

```powershell
php artisan migrate
```

---

### 8. Isi Data (Seeder)

```powershell
php artisan db:seed
```

> ⏳ Proses ini **1-2 menit** karena download data wilayah Aceh dari internet. Biarkan sampai selesai!

Output yang benar:
```
Database\Seeders\MasterDataSeeder ................ DONE
Database\Seeders\StoryMapSampleSeeder ............ DONE
Database\Seeders\AcehRealBoundariesSeeder ........ DONE
```

---

### 9. Build Asset (CSS/JS)

```powershell
npm run build
```

---

### 10. Jalankan Server

```powershell
php artisan serve
```

Buka browser → **http://127.0.0.1:8000** 🎉

---

## 🔄 Cara Kerja Tim dengan Git

### Ambil perubahan terbaru dari GitHub (lakukan SETIAP MULAI KERJA):
```powershell
git pull
```

### Simpan dan kirim perubahan ke GitHub (lakukan SETIAP SELESAI KERJA):
```powershell
git add .
git commit -m "feat: deskripsi singkat apa yang diubah"
git push
```

---

## 📁 Folder Kerja Masing-Masing

> ⚠️ **PENTING**: Edit HANYA di folder sektor kamu sendiri agar tidak bentrok!

| Anggota | Folder yang Dikerjakan |
|---------|----------------------|
| Kebencanaan | `resources/views/sektor/kebencanaan/` |
| Kependudukan | `resources/views/sektor/kependudukan/` |
| Pertanian | `resources/views/sektor/pertanian/` |
| Perikanan | `resources/views/sektor/perikanan/` |
| Perkebunan | `resources/views/sektor/perkebunan/` |

---

## ❓ Error Umum & Solusinya

### ❌ `composer: command not found`
→ Install Composer dari https://getcomposer.org/download/

### ❌ `php: command not found`
→ Install PHP atau tambahkan PHP ke PATH Windows

### ❌ Error koneksi database
→ Pastikan PostgreSQL sudah berjalan dan password di `.env` sudah benar

### ❌ `php artisan db:seed` error
→ Pastikan sudah jalankan `php artisan migrate` dulu sebelum seed

### ❌ Halaman tidak muncul / CSS berantakan
→ Jalankan `npm run build` atau `npm run dev`

---

## 📞 Butuh Bantuan?

Hubungi **Synthia** (pemilik repo) via WhatsApp grup tim 😊
