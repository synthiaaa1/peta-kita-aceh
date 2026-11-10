# 🗺️ Rencana Kerja & Peta Jalan (Roadmap) Proyek PetaKita Aceh
*Portal Data Geospasial Terpadu, Terbuka, dan Interaktif Pemerintah Provinsi Aceh*

Dokumen ini disusun sebagai pedoman rencana kerja tim pengembang (mahasiswa) dalam merealisasikan portal WebGIS / Geoportal Provinsi Aceh. Rencana kerja ini ditargetkan untuk diserahkan pada hari **Rabu**.

---

## 📈 1. Ringkasan Status Proyek Saat Ini (Milestone 0)
Sebelum melangkah ke target berikutnya, berikut adalah status kesiapan teknologi dan fitur yang telah diimplementasikan dalam sistem:

### **Yang SUDAH Selesai:**
- [x] **Arsitektur Dasar**: Integrasi Laravel 12 dengan Database Spasial PostgreSQL & ekstensi PostGIS.
- [x] **Manajemen Pengguna (User Management)**: Halaman manajemen user dan peran di Filament Admin Panel.
- [x] **Pembagian Hak Akses (RBAC)**: 
  - **Operator (Dinas/SKPA)** hanya bisa mengelola dataset miliknya sendiri dan mengajukan peninjauan (`pending_review`).
  - **Admin** memiliki hak penuh untuk menyetujui publikasi (`published`) dan menghapus data.
- [x] **Privasi Data**: Pemisahan 3 tingkat kerahasiaan data: *Publik* (Terbuka), *Terbatas* (Hanya Instansi Terpilih lewat Relasi Tags), dan *Tertutup* (Hanya Admin).
- [x] **Integrasi API Sistem**: Implementasi service penarikan 143 dataset dari API v2 SIG Aceh (`sig.acehprov.go.id`) dan API BNPB.
- [x] **Fitur Utama Peta**:
  - Peta Interaktif berbasis Leaflet JS dengan basemap switcher (Peta Standar, Satelit, Topografi, Dark Mode).
  - *Spatial Attribute Inspector* (Sisi Kanan Peta) untuk menampilkan info detail elemen wilayah saat diklik.
  - Fitur Autocomplete Geocoding (pencarian nama desa/kecamatan se-Aceh dan otomatis *zoom/flyTo* ke titik lokasi).
  - Alat ukur jarak & luas wilayah serta fungsi cetak peta (*Print Layout*).
- [x] **Desain Beranda**: Halaman depan modern bernuansa hijau-emas khas Aceh dengan animasi partikel halus.

---

## 🎯 2. Target Utama Minggu Depan (Penyelesaian Target Rapat)
Fokus utama tim untuk minggu ini hingga hari **Rabu** adalah memigrasi data simulasi/dummy menjadi data spasial yang riil serta memantapkan alur pengujian hak akses pengguna.

### **Rencana Aksi Segera (Selesai Sebelum Hari Rabu):**
1. **Pembersihan & Migrasi Data Spasial Asli Aceh**
   - **Masalah**: Data koordinat saat ini masih menggunakan batas wilayah tiruan (dummy bounding box persegi di Banda Aceh).
   - **Solusi**: Mengimpor berkas spasial asli (GeoJSON/Shapefile) batas wilayah 23 Kabupaten/Kota dan 290 Kecamatan di Provinsi Aceh ke database spasial PostgreSQL via PostGIS.
   - **Teknis**: Memanfaatkan modul `importGeoJson` pada sistem untuk mengonversi data batas wilayah riil yang diperoleh dari Bappeda Aceh atau SIG Aceh.

2. **Simulasi Alur Kerja Operator vs Admin (Live Testing)**
   - Menguji skenario pengunggahan peta terbatas oleh **Dinas Kesehatan** (contoh: Peta Sebaran Puskesmas).
   - Memastikan bahwa operator Dinas Kesehatan hanya bisa mengajukan peninjauan (`pending_review`) dan data tersebut **tidak muncul di publik** sebelum disetujui Admin.
   - Memastikan data terbatas hanya dapat dilihat oleh dinas terizin yang dipilih (misalnya Dinas Kesehatan dan Bappeda).

3. **Dokumentasi SNI ISO 19115:2012**
   - Mengintegrasikan kolom pengisian metadata spasial standar SNI ISO 19115:2012 pada saat operator mengunggah berkas XML Metadata.

---

## 📅 3. Peta Jalan Pengembangan Mingguan (Roadmap 4 Minggu)

Berikut adalah pembagian garis waktu kerja untuk 1 bulan ke depan:

### 🗓️ **Minggu 1: Integrasi Data Riil & Otorisasi Pengguna (Fokus Presentasi Hari Rabu)**
- [ ] Menghubungkan service database lokal ke file spasial (GeoJSON) batas administrasi resmi se-Aceh.
- [ ] Menyelesaikan alur input Metadata standar SNI ISO 19115:2012 melalui form unggahan XML.
- [ ] Uji coba visualisasi peta asli Aceh di browser untuk memastikan waktu rendering peta tetap cepat.
- [ ] **Serah Terima Rencana Kerja**: Mengumpulkan dokumen ini ke dosen pembimbing pada hari Rabu.

### 🗓️ **Minggu 2: Fitur Analytics & Pelacakan Pengunduhan (Download Tracking)**
- [ ] Mengaktifkan fitur pencatatan riwayat unduhan berkas GeoJSON oleh publik.
- [ ] Membangun dashboard analitik sederhana untuk Admin guna memantau dataset apa saja yang paling sering diunduh oleh publik.
- [ ] Mengoptimalkan *caching* spasial di Laravel agar query data PostGIS yang besar tidak membebani performa server.

### 🗓️ **Minggu 3: Integrasi Data BNPB/BPBA Aceh & Uji Keamanan**
- [ ] Menyempurnaan sinkronisasi otomatis data rawan bencana (tsunami, banjir, longsor) dari API BNPB secara berkala (*scheduled task*).
- [ ] Melakukan pengujian keamanan otorisasi (*authorization vulnerability audit*) untuk menjamin bahwa data berkategori **Terbatas** dan **Tertutup** sama sekali tidak bocor ke endpoint API publik.

### 🗓️ **Minggu 4: Pelatihan (UAT) & Peluncuran Portal**
- [ ] Melakukan uji coba bersama perwakilan Operator Dinas/SKPA (Dinas Kesehatan, Dinas Pendidikan, dll.).
- [ ] Menyusun panduan manual penggunaan portal (*User Manual Guide*) untuk Operator dan Admin.
- [ ] Deploy aplikasi secara resmi ke server hosting milik Pemerintah Provinsi Aceh (Staging/Production).

---

## 👥 4. Pembagian Tugas & Tanggung Jawab Tim

Untuk menjamin kelancaran pengerjaan proyek, tim pengembang dibagi menjadi beberapa peran penting:

1. **GIS & Data Engineer (Mahasiswa 1)**
   - Mengumpulkan data spasial resmi Aceh dalam format Shapefile/GeoJSON.
   - Bertanggung jawab atas migrasi data uji coba menjadi data batas wilayah riil di dalam PostgreSQL/PostGIS.
   - Mengintegrasikan parser metadata standar SNI ISO 19115:2012.

2. **Backend Developer (Mahasiswa 2)**
   - Mengelola sistem otorisasi pengguna (Operator vs Admin) dan filter privasi data (*scope queries*).
   - Membangun API untuk penarikan data berkala dari API BNPB / BPBA.
   - Membangun sistem *tracking* download file spasial publik.

3. **Frontend & UI/UX Developer (Mahasiswa 3)**
   - Mengembangkan peta interaktif Leaflet JS (penambahan kontrol layer, pencarian autocomplete, alat ukur).
   - Mempercantik antarmuka portal dengan ornamen visual bertema Aceh dan memastikan performa responsif di berbagai perangkat.
   - Menyempurnakan antarmuka *Spatial Attribute Inspector* dan penanganan ekspor data ke CSV.
