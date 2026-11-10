<p align="center">
  <a href="https://sig.acehprov.go.id" target="_blank">
    <h1 align="center">🗺️ PetaKita Aceh — Platform Geoportal Data Spasial Aceh</h1>
  </a>
</p>

<p align="center">
  <strong>Portal data geospasial terpadu, terbuka, dan interaktif Pemerintah Provinsi Aceh.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PostgreSQL-PostGIS-blue.svg" alt="PostGIS">
  <img src="https://img.shields.io/badge/Leaflet-1.9.4-green.svg" alt="Leaflet JS">
  <img src="https://img.shields.io/badge/License-MIT-brightgreen.svg" alt="License">
</p>

---

## 📌 Ikhtisar Fitur Utama

- **🗺️ Interactive WebGIS Viewer (`/map`)**:
  - Peta spasial interaktif berbasis Leaflet JS dengan dukungan multiterminal.
  - Layer switcher (Peta Standar, Citra Satelit, Topografi, & Dark Mode).
  - Tools pengukuran spasial (Ukur Jarak & Ukur Luas Hektar/M²).
  - **🖨️ Cetak Peta / Print Map** dengan tata letak resmi.
  - **📥 Export Data Atribut CSV** langsung dari Spatial Attribute Inspector.
  - Geocoding & Pencarian nama Desa, Kecamatan, dan Kabupaten se-Provinsi Aceh.
- **📂 Katalog Dataset Spasial (`/katalog`)**:
  - Penelusuran dataset peta berdasarkan sektor (Lingkungan Hidup, Bencana, Kesehatan, Education, dll.) dan Instansi OPD.
  - Filter pencarian cepat, metadata standar SNI ISO 19115:2012, dan preview GeoJSON.
- **📈 Real-Time Download Tracking System**:
  - Melacak jumlah dan riwayat pengunduhan file GeoJSON oleh publik secara otomatis dan transparan.
- **🔗 Integrasi API Publik v2 & BNPB**:
  - Endpoint REST API Publik `/api/datasets`, `/api/layers/{id}/geojson`, serta sinkronisasi otomatis data kebencanaan BNPB/BPBA Aceh (`/api/v2/external/bnpb-disaster`).
- **⚙️ Panel Admin Filament**:
  - Pengelolaan data OPD, Kategori, Dataset, Layer Spasial, Story Maps, dan Importir API Publik.

---

## 🚀 Persyaratan Sistem

- **PHP**: `^8.2` atau lebih baru
- **Database**: PostgreSQL 14+ dengan ekstensi **PostGIS** (`CREATE EXTENSION postgis;`)
- **Composer**: `^2.x`
- **Node.js**: `^18.x` atau `^20.x` & NPM

---

## 🔧 Panduan Instalasi Quickstart

1. **Clone Repository**:
   ```bash
   git clone https://github.com/username/peta-kita-aceh.git
   cd peta-kita-aceh
   ```

2. **Instalasi Dependency**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`)**:
   ```env
   APP_NAME="PetaKita Aceh"
   APP_URL=http://localhost:8000

   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=satu_peta_aceh
   DB_USERNAME=postgres
   DB_PASSWORD=your_password
   ```

4. **Generate Key & Jalankan Migrasi + Seeder**:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi dalam Mode Dev**:
   ```bash
   composer run dev
   # Atau: php artisan serve
   ```

---

## 🧪 Menjalankan Automated Tests

Proyek ini telah dilengkapi dengan suite pengujian otomatis berbasis PHPUnit/Pest:

```bash
php artisan test
```

Uji otomatis mencakup:
- Keberhasilan pemuatan Halaman Utama, WebGIS Viewer, dan Katalog.
- Validasi struktur GeoJSON pada endpoint API `/api/layers/{id}/geojson`.
- Pengujian stream download GeoJSON dan verifikasi pencatatan log pada tabel `dataset_downloads`.
- Endpoint integrasi data kebencanaan BNPB/BPBA.

---

## 📄 Lisensi

Platform ini dikembangkan di bawah lisensi [MIT License](LICENSE).
