<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi REST API Publik — PetaKita Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f4f6fb;
            --bg-surface: #ffffff;
            --accent: #1a7f4f;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --border: rgba(0,0,0,0.08);
            --font-main: 'Inter', sans-serif;
        }
        body {
            font-family: var(--font-main);
            background: var(--bg-base);
            color: var(--text-primary);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: var(--bg-surface);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        h1 { color: var(--accent); margin-top: 0; }
        h2 { border-bottom: 1px solid var(--border); padding-bottom: 8px; margin-top: 32px; }
        .endpoint {
            background: #f8f9fa;
            border-left: 4px solid var(--accent);
            padding: 12px 16px;
            font-family: monospace;
            font-size: 14px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 16px;
        }
        .method { font-weight: bold; color: var(--accent); margin-right: 8px; }
        .btn-back {
            display: inline-block;
            margin-bottom: 24px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .btn-back:hover { color: var(--accent); }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="btn-back">← Kembali ke Beranda</a>
        <h1>Dokumentasi Integrasi & REST API Publik</h1>
        <p>PetaKita Aceh mendukung integrasi data spasial otomatis melalui API Publik Versi 2 dari Portal SIG Aceh (<strong>sig.acehprov.go.id/api/v2</strong>) dan instansi nasional (BNPB).</p>
        
        <h2>1. Integrasi API Sumber Data Aceh</h2>
        <p>Pengembang dan sistem instansi dapat menarik dataset spasial publik langsung menggunakan API versi 2 berikut:</p>
        <div class="endpoint"><span class="method">API V2</span> https://sig.acehprov.go.id/api/v2/datasets</div>
        <p><strong>Cakupan Data:</strong> Terhubung otomatis dengan sekitar <strong>143 dataset publik</strong> lintas dinas/SKPA di Provinsi Aceh tanpa memerlukan penginputan manual satu per satu.</p>

        <h2>2. Integrasi Sumber Luar (Nasional)</h2>
        <p>Sistem ini dirancang untuk dapat melakukan penarikan data spasial dari instansi nasional seperti data kebencanaan spasial dari <strong>BNPB (Badan Nasional Penanggulangan Bencana)</strong>.</p>
        <div class="endpoint"><span class="method">API BNPB</span> https://sig.acehprov.go.id/api/v2/external/bnpb-disaster</div>

        <h2>3. Endpoint Local REST API Geoportal</h2>
        
        <h3>Mendapatkan Daftar Dataset Publik</h3>
        <div class="endpoint"><span class="method">GET</span> /api/datasets</div>
        
        <h3>Mendapatkan Fitur Spasial GeoJSON Layer</h3>
        <div class="endpoint"><span class="method">GET</span> /api/layers/{id}/geojson</div>

        <h3>Unduh File GeoJSON Layer</h3>
        <div class="endpoint"><span class="method">GET</span> /api/layers/{id}/download</div>

        <h2>Autentikasi</h2>
        <p>Saat ini, REST API Publik untuk baca-data (read-only) tidak memerlukan token autentikasi. Namun, kami menerapkan pembatasan *rate-limiting* untuk mencegah penyalahgunaan sistem.</p>
    </div>
</body>
</html>
