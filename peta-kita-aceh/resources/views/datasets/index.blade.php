<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Dataset — PetaKita Aceh</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition">
                ← Kembali ke Beranda
            </a>
            <span class="text-gray-300">|</span>
            <div class="flex items-center gap-2">
                <span class="text-xl">📊</span>
                <div>
                    <h1 class="text-sm font-bold text-gray-900 leading-tight">Katalog Dataset PetaKita Aceh</h1>
                    <p class="text-xs text-gray-500">Portal Data Terbuka & Metadata Spasial SNI ISO 19115</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full font-semibold">
                Wadah Dataset Siap Diisi
            </span>
            <a href="/map" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 transition">
                Buka Mapset ↗
            </a>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-6xl w-full mx-auto p-6 md:p-10 flex flex-col items-center justify-center">
        
        <!-- Placeholder Banner Siap Isi -->
        <div class="w-full bg-white border-2 border-dashed border-gray-300 rounded-3xl p-10 md:p-14 text-center shadow-sm">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-6 shadow-sm border border-emerald-100">
                📁
            </div>

            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3 font-display">
                Halaman Katalog Dataset
            </h2>

            <p class="text-gray-500 max-w-lg mx-auto text-sm md:text-base leading-relaxed mb-8">
                Halaman ini disiapkan khusus sebagai wadah penelusuran seluruh dataset tabel, statistik, dan berkas spasial terbuka dari SKPA se-Aceh. Konten siap diisi sesuai kebutuhan modul tim Anda.
            </p>

            <!-- Grid Preview Komponen yang Siap Diisi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl mx-auto text-left mb-8">
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200">
                    <span class="text-lg">🔍</span>
                    <h3 class="text-xs font-bold text-gray-800 mt-2">Filter & Pencarian</h3>
                    <p class="text-xs text-gray-400 mt-1">Filter berdasarkan SKPA, sektor, atau tahun rilis dataset.</p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200">
                    <span class="text-lg">📥</span>
                    <h3 class="text-xs font-bold text-gray-800 mt-2">Unduh Berkas</h3>
                    <p class="text-xs text-gray-400 mt-1">Format CSV, GeoJSON, Shapefile, dan PDF laporan statistik.</p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200">
                    <span class="text-lg">📑</span>
                    <h3 class="text-xs font-bold text-gray-800 mt-2">Standar Metadata</h3>
                    <p class="text-xs text-gray-400 mt-1">Struktur keterangan data berstandar SNI ISO 19115:2012.</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 text-xs text-gray-400 bg-gray-100 px-4 py-2 rounded-xl">
                <span>📍 Lokasi Berkas:</span>
                <code class="font-mono text-emerald-700 font-semibold">resources/views/datasets/index.blade.php</code>
            </div>
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} PetaKita Aceh — Pemerintah Provinsi Aceh
    </footer>

</body>
</html>

