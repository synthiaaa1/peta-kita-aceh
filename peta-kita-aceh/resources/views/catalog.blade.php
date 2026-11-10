<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Dataset Spasial - PetaKita Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f4f6fb;
            --bg-card: #ffffff;
            --bg-header: #ffffff;
            --accent: #198754;
            --accent-light: #e8f5ee;
            --accent-hover: #157347;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 2px 12px rgba(0,0,0,0.06);
            --shadow-hover: 0 10px 30px rgba(0,0,0,0.12);
            --font-main: 'Inter', sans-serif;
            --font-display: 'Outfit', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-main); background-color: var(--bg-base); color: var(--text-primary); line-height: 1.6; }

        /* HEADER */
        .header {
            background: var(--bg-header);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 14px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { width: 38px; height: 38px; background: linear-gradient(135deg, var(--accent), #34a870); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 10px rgba(25,135,84,0.3); }
        .logo-text { font-family: var(--font-display); font-size: 19px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
        .logo-text span { color: var(--accent); }
        .header-nav { display: flex; gap: 8px; }
        .nav-link { color: var(--text-secondary); text-decoration: none; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; font-size: 14px; }
        .nav-link:hover { color: var(--accent); background: var(--accent-light); }
        .nav-link.active { color: var(--accent); background: var(--accent-light); font-weight: 600; }

        /* CONTAINER */
        .container { max-width: 1240px; margin: 0 auto; padding: 32px 20px 60px; }

        /* HERO BAR */
        .page-header {
            background: linear-gradient(135deg, #198754 0%, #157347 50%, #0d5232 100%);
            color: white;
            padding: 56px 5%;
            text-align: center;
            border-radius: 16px;
            margin-bottom: 32px;
            box-shadow: 0 10px 25px rgba(25,135,84,0.25);
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right, rgba(255,255,255,0.15), transparent 60%); pointer-events: none;
        }
        .page-title { font-family: var(--font-display); font-size: 38px; margin-bottom: 12px; font-weight: 900; letter-spacing: -0.5px; }
        .page-subtitle { font-size: 16px; opacity: 0.92; max-width: 650px; margin: 0 auto; line-height: 1.6; }

        /* FILTER BAR */
        .filter-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 12px;
            align-items: center;
            box-shadow: var(--shadow);
        }
        .form-control {
            background: var(--bg-base);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 11px 16px;
            border-radius: 10px;
            font-family: var(--font-main);
            font-size: 14px;
            outline: none;
            width: 100%;
            transition: all 0.2s;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(25,135,84,0.15); background: #ffffff; }
        .btn-search {
            background: var(--accent);
            color: white;
            border: none;
            padding: 11px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            font-size: 14px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-search:hover { background: var(--accent-hover); transform: translateY(-1px); }

        /* QUICK CATEGORY CHIPS */
        .category-chips {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 12px;
            margin-bottom: 32px;
            scrollbar-width: thin;
        }
        .chip {
            background: white;
            border: 1px solid var(--border);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .chip:hover, .chip.active {
            background: var(--accent-light);
            border-color: var(--accent);
            color: var(--accent);
            font-weight: 600;
        }

        /* DATASET GRID */
        .dataset-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        .dataset-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .dataset-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--accent);
        }

        /* THUMBNAIL IMAGE & VECTOR BADGE */
        .card-image-wrapper {
            width: 100%;
            height: 160px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 16px;
            position: relative;
            background: linear-gradient(135deg, #198754 0%, #0d5232 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-image-wrapper.lingkungan { background: linear-gradient(135deg, #059669 0%, #064e3b 100%); }
        .card-image-wrapper.pendidikan { background: linear-gradient(135deg, #4f46e5 0%, #1e1b4b 100%); }
        .card-image-wrapper.bencana { background: linear-gradient(135deg, #dc2626 0%, #7f1d1d 100%); }
        .card-image-wrapper.kesehatan { background: linear-gradient(135deg, #0d9488 0%, #115e59 100%); }
        .card-image-wrapper.tata-ruang { background: linear-gradient(135deg, #d97706 0%, #78350f 100%); }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .dataset-card:hover .card-image { transform: scale(1.05); }

        .card-icon-fallback {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            gap: 6px;
        }
        .card-icon-fallback span.icon { font-size: 48px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); }
        .card-icon-fallback span.label { font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; opacity: 0.85; }

        .card-meta { display: flex; gap: 8px; margin-bottom: 12px; font-size: 12px; flex-wrap: wrap; }
        .tag { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; }
        .tag.category { background: var(--accent-light); color: var(--accent); }
        .tag.agency { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }

        .card-title {
            font-family: var(--font-display);
            font-size: 18px;
            margin-bottom: 10px;
            line-height: 1.35;
            font-weight: 700;
            color: var(--text-primary);
        }
        .card-desc {
            color: var(--text-secondary);
            font-size: 13px;
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border);
            padding-top: 14px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        .btn-view-data {
            color: var(--accent);
            font-weight: 700;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination { display: flex; justify-content: center; margin-top: 20px; }
    </style>
</head>
<body>

    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <div class="logo-icon">🗺️</div>
            <div class="logo-text">PetaKita<br><span>Aceh</span></div>
        </a>
        <nav class="header-nav">
            <a href="{{ url('/') }}" class="nav-link">Beranda</a>
            <a href="{{ url('/katalog') }}" class="nav-link active">Katalog Data</a>
            <a href="{{ url('/map') }}" class="nav-link">WebGIS</a>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Katalog Data Geospasial Aceh</h1>
            <p class="page-subtitle">Pusat katalog data spasial terpadu Provinsi Aceh. Dilengkapi cuplikan gambar (thumbnail), instansi pemilik data (OPD), dan kategori sektor resmi.</p>
        </div>

        <form action="{{ url('/katalog') }}" method="GET" class="filter-bar">
            <input type="text" name="q" class="form-control" placeholder="🔍  Cari nama dataset spasial atau kata kunci..." value="{{ request('q') }}">
            <select name="category" class="form-control" style="width: 210px;">
                <option value="">Semua Kategori Sektor</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="agency" class="form-control" style="width: 240px;">
                <option value="">Semua Instansi (OPD)</option>
                @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-search">
                <span>Cari Data</span> 🔍
            </button>
        </form>

        <!-- Quick Category Chips -->
        <div class="category-chips">
            <a href="{{ url('/katalog') }}" class="chip {{ !request('category') ? 'active' : '' }}">🌐 Semua Sektor</a>
            @foreach($categories as $c)
                @php
                    $icon = '🏷️';
                    $catLower = strtolower($c->name);
                    if(str_contains($catLower, 'lingkungan')) $icon = '🌿';
                    elseif(str_contains($catLower, 'pendidikan')) $icon = '🎓';
                    elseif(str_contains($catLower, 'bencana')) $icon = '🌊';
                    elseif(str_contains($catLower, 'kesehatan')) $icon = '🏥';
                    elseif(str_contains($catLower, 'tata ruang')) $icon = '🗺️';
                    elseif(str_contains($catLower, 'administrasi')) $icon = '🏛️';
                @endphp
                <a href="{{ url('/katalog?category='.$c->id) }}" class="chip {{ request('category') == $c->id ? 'active' : '' }}">
                    {{ $icon }} {{ $c->name }}
                </a>
            @endforeach
        </div>

        <div class="dataset-grid">
            @forelse($datasets as $ds)
            @php
                $catName = strtolower($ds->category->name ?? '');
                $wrapperClass = '';
                $iconSymbol = '🗺️';
                if(str_contains($catName, 'lingkungan')) { $wrapperClass = 'lingkungan'; $iconSymbol = '🌿'; }
                elseif(str_contains($catName, 'pendidikan')) { $wrapperClass = 'pendidikan'; $iconSymbol = '🎓'; }
                elseif(str_contains($catName, 'bencana')) { $wrapperClass = 'bencana'; $iconSymbol = '🌊'; }
                elseif(str_contains($catName, 'kesehatan')) { $wrapperClass = 'kesehatan'; $iconSymbol = '🏥'; }
                elseif(str_contains($catName, 'tata ruang')) { $wrapperClass = 'tata-ruang'; $iconSymbol = '🗺️'; }
            @endphp
            <a href="{{ url('/katalog/'.$ds->slug) }}" class="dataset-card">
                <!-- THUMBNAIL GAMBAR -->
                <div class="card-image-wrapper {{ $wrapperClass }}">
                    @if($ds->thumbnail_path)
                        <img src="{{ Storage::url($ds->thumbnail_path) }}" alt="{{ $ds->title }}" class="card-image">
                    @else
                        <img src="{{ asset('images/map-aceh-thumb.png') }}" alt="Peta Aceh" class="card-image">
                    @endif
                </div>

                <!-- META BADGES: KATEGORI & INSTANSI -->
                <div class="card-meta">
                    <span class="tag category">🏷️ {{ $ds->category->name ?? 'Umum' }}</span>
                    <span class="tag agency">🏢 {{ Str::limit($ds->agency->name ?? 'Pemerintah Aceh', 28) }}</span>
                </div>

                <!-- JUDUL & DESKRIPSI -->
                <h3 class="card-title">{{ $ds->title }}</h3>
                <p class="card-desc">{{ $ds->description }}</p>

                <!-- FOOTER METADATA -->
                <div class="card-footer">
                    <div>
                        <span>📅 {{ $ds->year }}</span> • 
                        <span>📍 EPSG:{{ $ds->srid }}</span>
                    </div>
                    <div class="btn-view-data">Lihat Detail →</div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; background: white; border-radius: 14px; border: 1px dashed var(--border);">
                <div style="font-size: 48px; margin-bottom: 16px;">🔍</div>
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">Dataset Tidak Ditemukan</h3>
                <p style="color: var(--text-secondary); font-size: 14px; max-width: 400px; margin: 0 auto;">Coba sesuaikan kata kunci pencarian atau ubah filter kategori dan instansi.</p>
            </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $datasets->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>

</body>
</html>
