# 🗺️ PROFIL PROYEK MAGANG: MODUL STORY MAPS PETAKITA ACEH
**Program Studi:** Teknik Informatika  
**Instansi Magang:** Dinas Komunikasi, Informatika dan Persandian Aceh (Diskominfo / Bidang Statistik)  
**Platform Induk:** PetaKita Aceh — Platform Geoportal & WebGIS Data Spasial Pemerintah Provinsi Aceh  
**Fokus Spesialisasi:** Pengembangan Fitur Story Maps (Scrollytelling Visualisasi Data Statistik Daerah)

---

## 📌 1. Latar Belakang & Masalah Riil yang Diselesaikan
* **Permasalahan di Instansi:**  
  Dinas Komunikasi, Informatika dan Persandian Aceh (khususnya Bidang Statistik) rutin menerbitkan data statistik daerah (angka kemiskinan, Indeks Pembangunan Manusia / IPM, stunting, ketenagakerjaan, dll.). Namun, data tersebut selama ini disajikan dalam bentuk buku laporan tebal atau tabel angka PDF (tabular) yang kaku, membosankan, dan sulit dipahami secara cepat oleh pengambil kebijakan (pimpinan daerah) maupun masyarakat umum.
* **Solusi yang Dibangun:**  
  Mengembangkan modul **Story Map** berbasis *scrollytelling* pada platform WebGIS PetaKita Aceh. Modul ini menggabungkan narasi cerita analitis di sisi kiri dan peta interaktif di sisi kanan yang otomatis terbang (*flyTo*) dan menyorot (*highlight*) wilayah kabupaten/kota yang sedang dibahas saat pengguna men-scroll layar.

---

## 💻 2. Spesifikasi Teknologi (Tech Stack)
* **Backend:** PHP 8.2 & Laravel 12 (Arsitektur MVC, Eloquent ORM, REST API)
* **Basis Data Spasial:** PostgreSQL 17.3 dengan ekstensi PostGIS (Sistem koordinat EPSG:4326 / WGS 84, fungsi spasial `ST_Union` dan `ST_AsGeoJSON`)
* **Frontend WebGIS:** Leaflet JS v1.9.4 & JavaScript ES6+ (`IntersectionObserver` API untuk mendeteksi event scroll)
* **Styling & Tampilan:** Tailwind CSS v4 & Blade Templating Engine
* **Admin CMS:** Filament v5 (Panel input form dan moderasi data untuk Operator dan Admin)

---

## 🗺️ 3. Kesiapan Data Spasial (100% Data Riil, Bukan Dummy)
* **Batas Administrasi 23 Kabupaten/Kota se-Aceh:** Sudah tersimpan permanen di database PostgreSQL/PostGIS (Layer ID 352, endpoint `/api/layers/352/geojson`), mencakup seluruh wilayah dari Sabang, Banda Aceh, Aceh Tengah, hingga Simeulue.
* **Batas Administrasi Pendukung:** 290 Kecamatan dan 6.576 Desa se-Aceh.
* **Sumber Data:** Data terbuka resmi Badan Pusat Statistik (BPS) dan Kementerian Dalam Negeri (Kemendagri) kode wilayah Aceh (`id11_aceh`).
* **Data Statistik Pendukung:** Data sekunder resmi publikasi *"Aceh Dalam Angka"* dari BPS Provinsi Aceh dan portal Satu Data Aceh (`data.acehprov.go.id`).

---

## 🛠️ 4. Porsi & Rincian Pekerjaan Riil Mahasiswa
Mahasiswa magang berfokus pada 3 pilar pekerjaan terukur:
1. **Penyusunan Konten Data Storytelling Statistik Aceh (Data & Narasi):**
   * Mengolah data statistik riil BPS Aceh (contoh studi kasus: *Disparitas Indeks Pembangunan Manusia dan Kemiskinan 23 Kabupaten/Kota di Aceh*).
   * Menghubungkan setiap bab narasi dengan titik koordinat *latitude, longitude, dan zoom level* kabupaten terkait.
2. **Pengembangan Frontend Scrollytelling Peta (Porsi Terbesar ~60%):**
   * Mengintegrasikan library Leaflet JS dengan `IntersectionObserver` agar kamera peta bergerak halus (*smooth flyTo cinematic*) saat bab narasi masuk ke viewport.
   * Menambahkan efek visual *polygon highlight* (kabupaten yang sedang dibahas menyala, wilayah lain meredup).
   * Menampilkan kartu metrik statistik melayang (*floating statistical metrics card*) berisi angka indikator pembangunan.
3. **Penyempurnaan Form Input Admin CMS (Backend/Admin ~25%):**
   * Mengembangkan form input di Filament Admin (`StoryMapForm.php`) agar operator dinas dapat memilih kabupaten langsung lewat dropdown tanpa harus menghafal dan mengetik angka koordinat manual.

---

## 🎯 5. Target Luaran (Output) Magang
1. Modul Story Map interaktif yang aktif berjalan dan siap diakses publik di platform PetaKita Aceh (`/story-maps`).
2. Panduan singkat bagi operator dinas untuk membuat dan mengelola cerita statistik baru melalui panel admin.
3. Laporan Magang / Kerja Praktik Teknik Informatika yang komprehensif, valid, dan dapat dipertanggungjawabkan dalam ujian sidang.
