# PetaKita Aceh - API v2 Documentation

Dokumentasi ini menjelaskan penggunaan endpoint REST API v2 untuk integrasi data geospasial.

## 1. Daftar Dataset
Mengambil daftar dataset yang tersedia berdasarkan otorisasi pengguna.

**Endpoint:** `GET /api/v2/datasets`

**Query Parameters:**
- `q` (string, opsional): Pencarian berdasarkan judul.
- `agency` (string/integer, opsional): Filter berdasarkan ID atau slug OPD.
- `category` (string, opsional): Filter berdasarkan slug kategori.
- `per_page` (integer, opsional): Jumlah data per halaman (maks: 100, default: 15).

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Batas Administrasi",
      "slug": "batas-administrasi",
      "status": "published",
      "access_level": "public",
      "category": { "id": 1, "name": "Batas", "slug": "batas" },
      "agency": { "id": 1, "name": "BAPPEDA", "code": "BPD" },
      "layers": [ ... ]
    }
  ],
  "links": { ... },
  "meta": { "total": 1, "per_page": 15, "current_page": 1 }
}
```

## 2. GeoJSON Spatial Service
Mengambil data spasial dari suatu layer dalam format GeoJSON. Mendukung filter Bounding Box (BBOX).

**Endpoint:** `GET /api/layers/{id}/geojson`

**Query Parameters:**
- `bbox` (string, opsional): Bounding box dengan format `minLng,minLat,maxLng,maxLat`. Contoh: `95.0,5.0,96.0,6.0`.
- `district_code` (string, opsional): Filter kode kabupaten/kota.
- `regency_code` (string, opsional): Filter kode kecamatan.

**Validasi BBOX:**
- Harus persis 4 angka dipisahkan koma.
- Lng harus berada di antara -180 hingga 180.
- Lat harus berada di antara -90 hingga 90.
- `minLng < maxLng` dan `minLat < maxLat`.

**Feature Limit & Truncation:**
Maksimal fitur yang dikembalikan dalam satu request adalah **2000**. Jika data melampaui limit, atribut `"truncated": true` akan disematkan di respons JSON, memberi tahu klien bahwa data telah dipotong.

**Response (200 OK):**
```json
{
  "type": "FeatureCollection",
  "truncated": false,
  "features": [
    {
      "type": "Feature",
      "id": 1,
      "properties": { "name": "Banda Aceh" },
      "geometry": {
        "type": "Point",
        "coordinates": [95.32, 5.55]
      }
    }
  ]
}
```

## 3. Rate Limiting
API dilindungi oleh pembatasan jumlah request (Rate Limiting) untuk menjaga stabilitas sistem:
- **Dataset API (`/api/v2/datasets`)**: Maksimal 60 request per menit per IP/User.
- **GeoJSON Service (`/api/layers/{id}/geojson`)**: Maksimal 30 request per menit (Karena komputasi BBOX spasial lebih berat).
- **Download Service (`/api/layers/{id}/download`)**: Maksimal 10 request per menit (serta proteksi anti-spam 5 menit per file).

## 4. Sistem Referensi Koordinat (CRS)
Seluruh endpoint geospasial pada API ini secara *default* menggunakan CRS **EPSG:4326 (WGS 84)**.

## 5. Keamanan dan Privasi (Cache)
- Untuk *Dataset Public*, data cache bersifat global dan dioptimasi penuh.
- Untuk *Dataset Restricted/Private*, cache diisolasi secara ketat berdasarkan token/ID pengguna yang terautentikasi untuk menghindari kebocoran data (*data leak*) lintas OPD. Field internal, informasi file path, dan log audit tidak diekspos melalui API Publik.
