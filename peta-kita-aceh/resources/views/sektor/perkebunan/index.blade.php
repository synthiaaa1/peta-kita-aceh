<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sektor Perkebunan — PetaKita Aceh</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition">
                ← Beranda Portal
            </a>
            <span class="text-gray-300">|</span>
            <div class="flex items-center gap-2">
                <span class="text-xl">☕</span>
                <div>
                    <h1 class="text-sm font-bold text-gray-900 leading-tight">Sektor Perkebunan Komoditas Unggulan Aceh</h1>
                    <p class="text-xs text-gray-500">Dinas Pertanian dan Perkebunan (Distanbun) Aceh</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full font-medium">
                Kanvas Siap Diisi
            </span>
            <a href="/map" class="text-xs text-gray-600 hover:text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                Peta Lengkap ↗
            </a>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6 grid grid-cols-12 gap-5">
        
        <!-- Kolom Kiri: Wadah Peta Leaflet (7 Kolom) -->
        <section class="col-span-12 lg:col-span-7 bg-white rounded-2xl border border-gray-200 shadow-sm p-4 flex flex-col min-h-[480px]">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-3">
                <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    🗺️ Peta Sebaran Komoditas & Konsesi HGU
                </h2>
                <span class="text-xs text-gray-400">EPSG:4326 PostGIS</span>
            </div>

            <!-- Wadah Peta Leaflet -->
            <div id="map-perkebunan" class="w-full flex-1 rounded-xl overflow-hidden border border-gray-100 bg-gray-100 min-h-[400px]"></div>
        </section>

        <!-- Kolom Kanan: Area Statistik & Tabel Siap Diisi (5 Kolom) -->
        <section class="col-span-12 lg:col-span-5 flex flex-col gap-5">
            
            <!-- Kartu KPI Ringkasan -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Ringkasan Komoditas Perkebunan</h3>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-xl p-3 text-center">
                        <span class="text-xs text-gray-400 block">Kopi Arabika Gayo</span>
                        <span class="text-lg font-bold text-gray-700">0 Ha</span>
                    </div>
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-xl p-3 text-center">
                        <span class="text-xs text-gray-400 block">Kelapa Sawit / HGU</span>
                        <span class="text-lg font-bold text-gray-700">0 Ha</span>
                    </div>
                </div>
                <div class="border border-dashed border-gray-200 rounded-xl p-4 text-center text-xs text-gray-400">
                    [ Area Indikator Nilam, Kakao & Cengkeh Siap Diisi ]
                </div>
            </div>

            <!-- Wadah Tabel Data -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex-1 flex flex-col">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Daftar Konsesi & Perkebunan Rakyat</h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl flex-1 flex flex-col items-center justify-center p-6 text-center text-gray-400">
                    <span class="text-3xl mb-2">🌿</span>
                    <p class="text-xs font-medium text-gray-600 mb-1">Tabel Data Perkebunan Siap Diisi</p>
                    <p class="text-xs text-gray-400 max-w-xs">
                        Tim Anda dapat menampilkan daftar izin usaha perkebunan (IUP), luas areal perkebunan rakyat, atau data ekspor kopi gayo di sini.
                    </p>
                </div>
            </div>

        </section>

    </main>

    <!-- Inisialisasi Peta Leaflet Aceh -->
    <script>
        const map = L.map('map-perkebunan').setView([4.695, 96.749], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap & PetaKita Aceh',
            maxZoom: 18
        }).addTo(map);
    </script>

</body>
</html>

