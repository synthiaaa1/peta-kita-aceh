# 📘 Panduan Penggunaan Portal PetaKita Aceh
*(Untuk Operator Dinas & Administrator)*

Selamat datang di Panduan Penggunaan Dasbor Manajemen PetaKita Aceh. Sistem ini digunakan untuk mengunggah, memverifikasi, dan mempublikasikan data geospasial Provinsi Aceh.

---

## 🔐 1. Tata Cara Masuk (Login)
1. Buka browser dan ketik alamat portal: `http://namadomain-anda.com/admin` (atau `localhost:8000/admin` jika di komputer lokal).
2. Masukkan **Alamat Email** dan **Kata Sandi** yang telah diberikan.
   - Contoh Email Admin: `admin@admin.com`
   - Contoh Email Operator: `pupr@aceh.go.id`
3. Klik tombol **Sign In**.

---

## 👷 2. Panduan Khusus Operator Dinas (SKPA)

Sebagai Operator, tugas utama Anda adalah mengunggah dan mengelola data milik dinas Anda sendiri.

### A. Menambah Dataset Baru
1. Di panel sebelah kiri, pilih menu **Katalog Geospasial** > **Dataset Spasial**.
2. Klik tombol **+ New Dataset Spasial** di kanan atas.
3. Isilah formulir secara lengkap:
   - **Kategori:** Pilih sektor yang sesuai (misal: Infrastruktur, Lingkungan).
   - **Judul Dataset:** Berikan nama yang jelas (Contoh: "Batas Jalan Provinsi Aceh 2026").
   - **Slug URL:** Akan terisi otomatis.
   - **Status Publikasi:** Pilih **"Kirim untuk Ditinjau Admin"**. (Catatan: Anda tidak bisa langsung menayangkannya ke publik).
   - **Kategori Akses Data:**
     - *Terbuka:* Publik bisa mengunduh.
     - *Terbatas:* Hanya dinas tertentu yang bisa melihat. Jika memilih ini, isi kolom **Dinas / Instansi Terizin**.
   - **File Metadata XML:** (Opsional) Unggah berkas `.xml` dengan format SNI ISO 19115. Sistem akan otomatis menyaring Bounding Box dan ringkasan data.
4. Klik **Create**.

### B. Menambahkan Layer Peta
Setelah dataset terbuat, Anda harus melampirkan "Layer" agar peta bisa tampil.
1. Pilih menu **Katalog Geospasial** > **Layers**.
2. Klik **+ New Layer**.
3. Pilih Dataset yang baru saja Anda buat.
4. Beri Nama Layer.
5. Klik **Create**. *Catatan: Tim GIS Anda akan memproses koneksi GeoJSON/Shapefile ke layer ini di database.*

---

## 👨‍💼 3. Panduan Khusus Administrator (Super Admin)

Admin memiliki kendali penuh dan bertugas meninjau kiriman Operator.

### A. Meninjau (Review) & Menyetujui Data
1. Buka menu **Dataset Spasial**.
2. Cari dataset yang statusnya memiliki lambang jam (kuning) bertuliskan **"Menunggu Tinjauan Admin"**.
3. Klik tombol pensil (**Edit**) di sebelah kanan baris tabel.
4. Periksa kebenaran data (Judul, Akses, dan Deskripsi).
5. Pada kolom **Status Publikasi**, ubah menjadi **"Disetujui (Tayang ke Publik)"**.
6. Klik **Save Changes**. Data tersebut kini bisa dilihat masyarakat di halaman depan portal.

### B. Memantau Statistik Unduhan
1. Buka halaman utama **Dashboard** (klik logo rumah di kiri atas).
2. Lihat grafik **5 Dataset Paling Sering Diunduh**.
3. Grafik ini menunjukkan popularitas dataset di mata publik, diukur dari berapa kali GeoJSON-nya diunduh.

### C. Manajemen Pengguna (Menambah Operator Baru)
1. Pilih menu **Pengaturan Akses** (jika menggunakan Filament Shield) atau **Users**.
2. Klik **+ New User**.
3. Isi Nama, Email, dan Password untuk dinas baru tersebut.
4. Pastikan untuk menugaskan **Role** sebagai `operator` dan memilih **Instansi (Agency)** yang tepat.
5. Klik **Create**.

---
*© 2026 Pemerintah Provinsi Aceh - Dinas Komunikasi Informatika dan Persandian*
