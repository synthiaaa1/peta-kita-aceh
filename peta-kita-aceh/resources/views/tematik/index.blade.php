<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Peta Tematik - PetaKita Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f9fafb; margin:0; padding:0; }
        .header { background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .nav-logo { font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 700; color: #111827; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .nav-links a { margin-left: 24px; text-decoration: none; color: #4b5563; font-weight: 500; font-size: 14px; transition: 0.2s; }
        .nav-links a:hover { color: #10b981; }

        .tematik-hero {
            background: linear-gradient(135deg, #0f766e, #064e3b);
            color: white;
            padding: 60px 40px;
            text-align: center;
        }
        .tematik-hero h1 { font-family: 'Outfit', sans-serif; font-size: 36px; margin: 0 0 12px 0; }
        .tematik-hero p { font-size: 16px; opacity: 0.9; max-width: 600px; margin: 0 auto; line-height: 1.5; }

        .filters-bar {
            background: white;
            padding: 16px 40px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            gap: 16px;
            justify-content: center;
        }
        .filter-btn {
            padding: 8px 16px;
            border-radius: 99px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #4b5563;
            background: #f3f4f6;
            transition: 0.2s;
        }
        .filter-btn:hover { background: #e5e7eb; }
        .filter-btn.active { background: #10b981; color: white; }

        .tematik-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .map-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .map-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.06);
            border-color: #10b981;
        }
        .map-thumb {
            width: 100%;
            height: 180px;
            background: #e5e7eb;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .map-type-badge {
            position: absolute;
            top: 12px; right: 12px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            backdrop-filter: blur(4px);
        }
        .map-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        .map-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0; line-height: 1.3; }
        .map-desc { font-size: 13px; color: #6b7280; line-height: 1.5; margin-bottom: 16px; flex: 1; }
        .map-footer {
            display: flex; justify-content: space-between; align-items: center;
            border-top: 1px solid #f3f4f6;
            padding-top: 16px;
            font-size: 12px;
            color: #9ca3af;
        }
        
        .empty-state { text-align: center; padding: 60px 20px; color: #6b7280; grid-column: 1 / -1; }

        /* Modal Styles */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);
            display: none; justify-content: center; align-items: center; z-index: 1000;
            opacity: 0; transition: opacity 0.3s;
        }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal-container {
            background: white; border-radius: 16px; width: 90%; max-width: 800px;
            max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            transform: scale(0.95); transition: transform 0.3s;
        }
        .modal-overlay.active .modal-container { transform: scale(1); }
        .modal-header {
            padding: 24px; border-bottom: 1px solid #e5e7eb;
            display: flex; justify-content: space-between; align-items: flex-start;
            position: sticky; top: 0; background: white; z-index: 10;
        }
        .modal-title-area { flex: 1; padding-right: 20px; }
        .modal-title { font-family: 'Outfit', sans-serif; font-size: 24px; font-weight: 700; color: #111827; margin: 0 0 8px 0; }
        .modal-actions { display: flex; gap: 12px; align-items: center; }
        .btn-visit {
            background: #10b981; color: white; padding: 10px 20px; border-radius: 8px;
            text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-visit:hover { background: #059669; }
        .btn-close {
            background: #f3f4f6; border: none; width: 36px; height: 36px; border-radius: 50%;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #4b5563; transition: 0.2s;
        }
        .btn-close:hover { background: #e5e7eb; color: #111827; }
        
        .modal-body { padding: 24px; }
        .modal-img-preview {
            width: 100%; height: auto; min-height: 300px; max-height: 400px; object-fit: cover;
            border-radius: 12px; margin-bottom: 24px; border: 1px solid #e5e7eb;
        }
        .modal-tabs { display: flex; border-bottom: 2px solid #e5e7eb; margin-bottom: 24px; }
        .modal-tab {
            padding: 12px 0; margin-right: 32px; font-weight: 600; color: #10b981;
            border-bottom: 2px solid #10b981; margin-bottom: -2px; cursor: pointer;
        }
        .info-grid { display: grid; grid-template-columns: 140px 1fr; gap: 16px 24px; font-size: 15px; }
        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #111827; font-weight: 500; }
    </style>
</head>
<body>

    <header class="header">
        <a href="/" class="nav-logo">
            🗺️ PetaKita <span>Aceh</span>
        </a>
        <nav class="nav-links">
            <a href="/">Beranda</a>
            <a href="/katalog">Katalog Data</a>
            <a href="/tematik" style="color: #10b981;">Peta Tematik</a>
            <a href="/story-maps">Story Maps</a>
        </nav>
    </header>

    <div class="tematik-hero">
        <h1>Galeri Peta Tematik</h1>
        <p>Kumpulan peta tematik interaktif dan peta layout statis dari berbagai instansi pemerintah Provinsi Aceh, siap dieksplorasi.</p>
    </div>

    <div class="filters-bar">
        <a href="/tematik" class="filter-btn {{ !$type ? 'active' : '' }}">Semua Peta</a>
        <a href="/tematik?visualization-type=interactive" class="filter-btn {{ $type == 'interactive' ? 'active' : '' }}">Interaktif WebGIS</a>
        <a href="/tematik?visualization-type=layout" class="filter-btn {{ $type == 'layout' ? 'active' : '' }}">Peta Layout (Statis)</a>
    </div>

    <div class="tematik-grid">
        @forelse($maps as $map)
            @php
                $mapUrl = $map->source_url ?: ($map->type == 'interactive' ? url('/map?tematik_id='.$map->id) : ($map->file_path ? Storage::url($map->file_path) : '#'));
                $thumbnailUrl = $map->thumbnail ? Storage::url($map->thumbnail) : 'https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                $mapData = [
                    'title' => $map->title,
                    'description' => $map->description,
                    'type' => $map->type == 'interactive' ? 'Peta Interaktif' : 'Peta Layout',
                    'agency' => optional($map->agency)->name ?? 'Pemerintah Aceh',
                    'year' => $map->created_at->format('Y'),
                    'thumbnail' => $thumbnailUrl,
                    'url' => $mapUrl
                ];
            @endphp
            <button onclick="openMapModal(this)" data-map="{{ json_encode($mapData) }}" class="map-card" style="text-align: left; border: 1px solid #e5e7eb; cursor: pointer; padding: 0; background: white;">
                <div class="map-thumb" style="background-image: url('{{ $thumbnailUrl }}');">
                    <div class="map-type-badge">{{ $map->type == 'interactive' ? 'Interaktif' : 'Layout' }}</div>
                </div>
                <div class="map-content">
                    <h3 class="map-title">{{ $map->title }}</h3>
                    <p class="map-desc">{{ \Illuminate\Support\Str::limit($map->description, 100) }}</p>
                    <div class="map-footer">
                        <span>🏢 {{ optional($map->agency)->name ?? 'Pemerintah Aceh' }}</span>
                        <span>{{ $map->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </button>
        @empty
            <div class="empty-state">
                <div style="font-size: 40px; margin-bottom: 16px;">📭</div>
                <h3>Belum ada Peta Tematik</h3>
                <p>Silakan gunakan filter lain atau kembali lagi nanti.</p>
            </div>
        @endforelse
    </div>
    
    <div style="display: flex; justify-content: center; padding: 20px;">
        {{ $maps->links() }}
    </div>

    <!-- Modal Element -->
    <div class="modal-overlay" id="mapModal" onclick="closeMapModal(event)">
        <div class="modal-container" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title-area">
                    <h2 class="modal-title" id="modalTitle">Peta Tematik</h2>
                </div>
                <div class="modal-actions">
                    <a href="#" target="_blank" class="btn-visit" id="modalBtnUrl">Kunjungi halaman</a>
                    <button class="btn-close" onclick="closeMapModal()">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <img src="" alt="Map Preview" class="modal-img-preview" id="modalImg">
                
                <div class="modal-tabs">
                    <div class="modal-tab">Informasi Umum</div>
                </div>

                <div class="info-grid">
                    <div class="info-label">Deskripsi</div>
                    <div class="info-value" id="modalDesc">-</div>
                    
                    <div class="info-label">Topik</div>
                    <div class="info-value">Lingkungan Hidup & Bencana</div>
                    
                    <div class="info-label">Tahun Rilis</div>
                    <div class="info-value" id="modalYear">-</div>
                    
                    <div class="info-label">Tipe Peta</div>
                    <div class="info-value" id="modalType">-</div>
                    
                    <div class="info-label">Pengolah Data</div>
                    <div class="info-value" id="modalAgency">-</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('mapModal');
        
        function openMapModal(btn) {
            const data = JSON.parse(btn.dataset.map);
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalDesc').textContent = data.description || '-';
            document.getElementById('modalType').textContent = data.type;
            document.getElementById('modalAgency').textContent = data.agency;
            document.getElementById('modalYear').textContent = data.year;
            document.getElementById('modalImg').src = data.thumbnail;
            
            const btnUrl = document.getElementById('modalBtnUrl');
            btnUrl.href = data.url;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMapModal(e) {
            // only close if click is on overlay itself or close btn (handled by onclick on btn)
            if (e && e.target !== modal && e.type === 'click') return;
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
</body>
</html>
