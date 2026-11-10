# Rancangan Kegiatan Implementasi dan Pengembangan PetaKita Aceh (5 Minggu)

Rancangan kegiatan ini memuat tahapan implementasi, kustomisasi, pengujian, hingga peluncuran platform **PetaKita Aceh** selama durasi 5 minggu.

## Minggu 1: Inisialisasi, Setup Infrastruktur, dan Konfigurasi Dasar
**Fokus Utama:** Memastikan lingkungan sistem berjalan dengan baik di server pengembangan (Staging/Development) dan memahami struktur data.

* **Hari 1-2:** Setup server (VPS/Cloud), instalasi OS, Nginx/Apache, PHP 8.2+, Node.js, dan PostgreSQL beserta ekstensi PostGIS.
* **Hari 3:** Kloning repositori PetaKita Aceh ke server, pengaturan environment (`.env`), dan eksekusi `composer install` & `npm install`.
* **Hari 4:** Migrasi database dan eksekusi seeder (`php artisan migrate --seed`) untuk mengunduh dan menyuntikkan data spasial awal (batas wilayah).
* **Hari 5:** Pengujian akses awal ke halaman publik, WebGIS Viewer (`/map`), dan halaman Admin Panel (`/admin`).

---

## Minggu 2: Kustomisasi Tampilan, Identitas Visual, dan Frontend
**Fokus Utama:** Menyesuaikan identitas visual (logo, warna, branding) aplikasi agar sesuai dengan standar Pemerintah Provinsi Aceh.

* **Hari 1-2:** Penggantian aset visual (Logo, Favicon) dan kustomisasi skema warna utama (Tailwind CSS / Vanilla CSS / Filament Theme).
* **Hari 3:** Penyesuaian konten statis pada Halaman Utama (Beranda), *Footer*, dan *About* jika diperlukan.
* **Hari 4:** Modifikasi antarmuka WebGIS Viewer, penambahan opsi basemap kustom atau penyesuaian *layer switcher*.
* **Hari 5:** *Review* dan *Quality Assurance* (QA) terhadap responsivitas tampilan (Mobile, Tablet, Desktop).

---

## Minggu 3: Integrasi Data Spasial Eksternal dan Manajemen Dataset
**Fokus Utama:** Memasukkan data spasial rill milik instansi OPD (Organisasi Perangkat Daerah) ke dalam katalog dan sistem PetaKita.

* **Hari 1-2:** Konsolidasi data spasial (Shapefile/GeoJSON) dari berbagai OPD terkait (seperti Dinas Lingkungan Hidup, Bencana, Kesehatan).
* **Hari 3:** Penginputan data meta (Kategori, Instansi) dan upload dataset spasial melalui Admin Panel Filament.
* **Hari 4:** Pengujian integrasi API Publik (seperti API BNPB/BPBA) untuk memastikan data kebencanaan otomatis tersinkronisasi.
* **Hari 5:** Verifikasi data pada fitur Spatial Attribute Inspector dan Katalog Dataset (`/katalog`). 

---

## Minggu 4: Pengujian Sistem (Testing), Optimalisasi, dan Keamanan
**Fokus Utama:** Memastikan sistem bebas dari *bug*, stabil saat diakses banyak pengguna, dan aman.

* **Hari 1:** Eksekusi pengujian otomatis (Automated Tests) menggunakan `php artisan test` untuk memastikan endpoint API dan fitur utama lulus uji.
* **Hari 2:** *Performance Tuning*: Konfigurasi *caching* Laravel (`config:cache`, `route:cache`, `view:cache`) dan *database indexing* di PostgreSQL.
* **Hari 3:** Uji beban (Load Testing) ringan pada WebGIS Viewer saat memuat layer GeoJSON berukuran besar (ratusan MB).
* **Hari 4:** *Security Audit*: Memastikan hak akses *role-based* (Admin vs Operator) di panel Filament berfungsi tanpa celah.
* **Hari 5:** Perbaikan (*Bug fixing*) dari temuan yang didapat selama proses pengujian.

---

## Minggu 5: Deployment Produksi (Go-Live) dan Pelatihan Pengguna
**Fokus Utama:** Memindahkan aplikasi dari server *staging* ke server *production* dan serah terima ke tim pengelola.

* **Hari 1-2:** Migrasi dan Deployment ke Server Produksi (Konfigurasi Domain `sig.acehprov.go.id`, instalasi SSL/HTTPS, dan optimasi Nginx).
* **Hari 3:** *Final Sanity Check* di lingkungan produksi untuk memastikan fitur peta, *download*, dan *print map* berfungsi 100%.
* **Hari 4:** Pelatihan (Training) atau Sosialisasi penggunaan aplikasi (Admin, Operator OPD, dan Publik).
* **Hari 5:** Peluncuran resmi (Go-Live), serah terima (*Handover*) dokumentasi sistem, dan dimulainya fase pemeliharaan (*Maintenance*).
