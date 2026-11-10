# Frontend Code Snapshot for UI/UX Mockup AI

This file contains the frontend source code of the project. You can use this to generate interactive mockups or understand the current UI structure.

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/api-docs.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - PetaKita Aceh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .markdown-body {
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif;
            font-size: 16px;
            line-height: 1.5;
            word-wrap: break-word;
        }
        .markdown-body h1, .markdown-body h2 {
            border-bottom: 1px solid #eaecef;
            padding-bottom: .3em;
            margin-top: 24px;
            margin-bottom: 16px;
        }
        .markdown-body pre {
            background-color: #f6f8fa;
            border-radius: 3px;
            padding: 16px;
            overflow: auto;
        }
        .markdown-body code {
            background-color: rgba(27,31,35,.05);
            border-radius: 3px;
            padding: .2em .4em;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    PetaKita Aceh
                </h1>
                <a href="/" class="text-indigo-600 hover:text-indigo-900">Kembali ke Beranda</a>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="bg-white px-8 py-8 shadow sm:rounded-lg">
                    <div class="markdown-body">
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/catalog-detail.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $dataset->title }} - PetaKita Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f4f6fb;
            --bg-card: #ffffff;
            --accent: #1a7f4f;
            --accent-light: #e6f5ed;
            --accent-hover: #155f3a;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 2px 12px rgba(0,0,0,0.07);
            --font-main: 'Inter', sans-serif;
            --font-display: 'Outfit', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-main); background-color: var(--bg-base); color: var(--text-primary); line-height: 1.6; }

        /* HEADER */
        .header {
            background: #ffffff; border-bottom: 1px solid var(--border); box-shadow: var(--shadow);
            padding: 14px 5%; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100;
        }
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--accent), #34a870); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .logo-text { font-family: var(--font-display); font-size: 18px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
        .logo-text span { color: var(--accent); }
        .header-nav { display: flex; gap: 8px; }
        .nav-link { color: var(--text-secondary); text-decoration: none; font-weight: 500; padding: 6px 14px; border-radius: 8px; transition: all 0.2s; font-size: 14px; }
        .nav-link:hover, .nav-link.active { color: var(--accent); background: var(--accent-light); }

        /* BREADCRUMB */
        .breadcrumb-bar { background: #fff; border-bottom: 1px solid var(--border); padding: 12px 5%; }
        .back-link { color: var(--accent); text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; }
        .back-link:hover { text-decoration: underline; }

        /* HERO */
        .page-hero { background: linear-gradient(135deg, var(--accent) 0%, #2eb87d 100%); color: white; padding: 48px 5%; }
        .meta-tags { display: flex; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
        .tag { padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 500; }
        .tag.category { background: rgba(255,255,255,0.22); color: white; }
        .tag.status { background: rgba(255,255,255,0.15); color: white; }
        .page-title { font-family: var(--font-display); font-size: 36px; margin-bottom: 10px; font-weight: 900; }
        .page-desc { opacity: 0.88; font-size: 16px; max-width: 700px; }

        /* CONTAINER */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }

        /* LAYOUT */
        .grid-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }

        /* SECTION */
        .section-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 28px; margin-bottom: 24px; box-shadow: var(--shadow); }
        .section-title { font-family: var(--font-display); font-size: 20px; margin-bottom: 20px; color: var(--accent); display: flex; align-items: center; gap: 8px; }
        .section-title::after { content: ''; flex: 1; height: 2px; background: var(--border); margin-left: 10px; }

        /* DATA TABLE */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 11px 12px; border-bottom: 1px solid var(--border); text-align: left; font-size: 14px; }
        .data-table th { color: var(--text-secondary); width: 38%; font-weight: 500; background: var(--bg-base); }
        .data-table tr:last-child th, .data-table tr:last-child td { border-bottom: none; }

        /* LAYERS */
        .layer-card { background: var(--bg-base); border: 1px solid var(--border); border-radius: 10px; padding: 16px 20px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
        .layer-info h4 { font-size: 16px; margin-bottom: 3px; font-weight: 600; }
        .layer-info p { color: var(--text-secondary); font-size: 13px; }

        .btn { padding: 9px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 13px; border: none; transition: all 0.2s; }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-ghost { background: white; color: var(--text-primary); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg-base); }

        /* SIDEBAR */
        .sidebar-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 22px; margin-bottom: 20px; box-shadow: var(--shadow); }
        .sidebar-card h3 { font-family: var(--font-display); margin-bottom: 12px; font-size: 17px; }
        .sidebar-card p { color: var(--text-secondary); font-size: 14px; margin-bottom: 14px; }
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

    <div class="breadcrumb-bar">
        <a href="{{ url('/katalog') }}" class="back-link">← Kembali ke Katalog</a>
    </div>

    <div class="page-hero">
        <div class="meta-tags">
            <span class="tag category">{{ $dataset->category->name ?? 'Uncategorized' }}</span>
            <span class="tag status">{{ $dataset->year }}</span>
            <span class="tag status">{{ ucfirst($dataset->status) }}</span>
        </div>
        <h1 class="page-title">{{ $dataset->title }}</h1>
        <p class="page-desc">{{ $dataset->description }}</p>
    </div>

    <div class="container">
        <div class="grid-layout">
            <div class="main-content">
                <div class="section-card">
                    @if($dataset->metadata)
                    <div style="margin-bottom: 20px; font-size: 14px; background: var(--bg-base); padding: 12px; border-radius: 8px;">
                        <strong>Identifier Metadata:</strong> {{ $dataset->metadata->metadata_identifier ?? '-' }}
                    </div>
                    @endif

                    <!-- Tabs Header -->
                    <div class="metadata-tabs" style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border);">
                        <button class="tab-btn active" onclick="openTab('info')" style="padding: 10px 16px; border: none; background: transparent; cursor: pointer; border-bottom: 2px solid var(--accent); font-weight: 600; color: var(--accent);">Informasi Dataset</button>
                        <button class="tab-btn" onclick="openTab('spasial')" style="padding: 10px 16px; border: none; background: transparent; cursor: pointer; font-weight: 500; color: var(--text-secondary);">Spasial & Kualitas</button>
                    </div>

                    <!-- Tab Content: Informasi Dataset -->
                    <div id="tab-info" class="tab-content" style="display: block;">
                        <table class="data-table">
                            <tbody>
                                <tr>
                                    <th>Instansi Walidata</th>
                                    <td>{{ $dataset->agency->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Pembuatan Data</th>
                                    <td>{{ $dataset->metadata->purpose ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori Topik</th>
                                    <td>{{ $dataset->metadata->topic_category ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kata Kunci</th>
                                    <td>
                                        @if($dataset->metadata && $dataset->metadata->keywords)
                                            @foreach($dataset->metadata->keywords as $keyword)
                                                <span class="tag" style="background:#e5e7eb; color:#374151; font-size: 12px;">{{ $keyword }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Publikasi</th>
                                    <td>{{ \Carbon\Carbon::parse($dataset->published_at)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Kontak Penanggung Jawab</th>
                                    <td>{{ $dataset->metadata->contact_person ?? '-' }} ({{ $dataset->metadata->contact_email ?? '-' }})</td>
                                </tr>
                            </tr>
                            <tr>
                                <th>Hak Akses</th>
                                <td>
                                    @if($dataset->access_level == 'public')
                                        <span class="tag" style="background:#e6f5ed; color:#1a7f4f;">Terbuka (Publik)</span>
                                    @elseif($dataset->access_level == 'restricted')
                                        <span class="tag" style="background:#fef3c7; color:#d97706;">Terbatas</span>
                                    @else
                                        <span class="tag" style="background:#fee2e2; color:#b91c1c;">Tertutup</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total Unduhan</th>
                                <td><strong>{{ number_format($dataset->total_downloads) }}</strong> kali</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                    <!-- Tab Content: Spasial & Kualitas -->
                    <div id="tab-spasial" class="tab-content" style="display: none;">
                        <table class="data-table">
                            <tbody>
                                <tr>
                                    <th>Sistem Referensi Spasial</th>
                                    <td>{{ $dataset->metadata->coordinate_system ?? ('EPSG:' . $dataset->srid) }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Geometri</th>
                                    <td>{{ $dataset->metadata->geometry_type ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Skala / Resolusi</th>
                                    <td>{{ $dataset->metadata?->scale_denominator ? '1:' . number_format($dataset->metadata->scale_denominator) : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bounding Box</th>
                                    <td>
                                        @if($dataset->metadata && $dataset->metadata->bounding_box)
                                            [ {{ implode(', ', $dataset->metadata->bounding_box) }} ]
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pernyataan Kualitas Data</th>
                                    <td>{{ $dataset->metadata->data_quality_statement ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pembaruan Terakhir</th>
                                    <td>{{ $dataset->metadata?->last_update_date ? \Carbon\Carbon::parse($dataset->metadata->last_update_date)->format('d M Y') : '-' }} ({{ ucfirst($dataset->metadata?->update_frequency ?? '-') }})</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="section-card">
                    <h2 class="section-title">🗺️ Daftar Layer Peta</h2>
                    @forelse($dataset->layers as $layer)
                    <div class="layer-card">
                        <div class="layer-info">
                            <h4>{{ $layer->name }}</h4>
                            <p>Tipe Geometri: <strong>{{ ucfirst($layer->geometry_type) }}</strong></p>
                        </div>
                        <a href="{{ url('/api/layers/' . $layer->id . '/download') }}" class="btn btn-primary" download>
                            ↓ Unduh GeoJSON
                        </a>
                    </div>
                    @empty
                    <p style="color: var(--text-secondary); font-size: 14px;">Belum ada layer spasial yang tersedia untuk dataset ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-card">
                    <h3>🌍 Visualisasi Peta</h3>
                    <p>Buka WebGIS untuk melihat layer-layer dataset ini secara langsung di atas peta interaktif.</p>
                    <a href="{{ url('/map') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">Buka WebGIS →</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active');
                el.style.borderBottom = 'none';
                el.style.color = 'var(--text-secondary)';
                el.style.fontWeight = '500';
            });

            // Show selected tab
            document.getElementById('tab-' + tabName).style.display = 'block';
            
            // Highlight selected button
            const activeBtn = event.currentTarget;
            activeBtn.classList.add('active');
            activeBtn.style.borderBottom = '2px solid var(--accent)';
            activeBtn.style.color = 'var(--accent)';
            activeBtn.style.fontWeight = '600';
        }
    </script>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/catalog.blade.php

```blade
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

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/docs-api.blade.php

```blade
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

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/docs-metadata.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standar Metadata SNI ISO 19115 — PetaKita Aceh</title>
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
        .btn-back {
            display: inline-block;
            margin-bottom: 24px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .btn-back:hover { color: var(--accent); }
        .meta-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 14px; }
        .meta-table th, .meta-table td { border: 1px solid var(--border); padding: 12px; text-align: left; }
        .meta-table th { background: var(--bg-base); font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="btn-back">← Kembali ke Beranda</a>
        <h1>Standar Metadata SNI ISO 19115</h1>
        <p>PetaKita Aceh berkomitmen untuk menjaga kualitas data spasial. Oleh karena itu, setiap dataset yang dipublikasikan diwajibkan untuk dilengkapi dengan metadata yang merujuk pada standar <strong>SNI ISO 19115:2012</strong> (Informasi Geografis - Metadata).</p>
        
        <h2>Apa itu SNI ISO 19115?</h2>
        <p>SNI ISO 19115 adalah standar yang mendefinisikan skema yang diperlukan untuk mendeskripsikan informasi geografis dan layanannya. Standar ini memberikan informasi tentang identifikasi, luasan (extent), kualitas, skema spasial dan waktu, referensi spasial, dan distribusi dari data digital geografis.</p>

        <h2>Elemen Inti Metadata</h2>
        <p>Berikut adalah beberapa elemen inti metadata yang kami terapkan pada setiap dataset di platform ini:</p>
        
        <table class="meta-table">
            <thead>
                <tr>
                    <th>Elemen (Element)</th>
                    <th>Deskripsi (Description)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Title</strong></td>
                    <td>Nama dari dataset atau layer spasial.</td>
                </tr>
                <tr>
                    <td><strong>Abstract</strong></td>
                    <td>Ringkasan naratif mengenai isi data.</td>
                </tr>
                <tr>
                    <td><strong>Dataset Language</strong></td>
                    <td>Bahasa yang digunakan di dalam dataset.</td>
                </tr>
                <tr>
                    <td><strong>Topic Category</strong></td>
                    <td>Tema klasifikasi dari data (misal: Batas Administrasi, Lingkungan).</td>
                </tr>
                <tr>
                    <td><strong>Spatial Resolution</strong></td>
                    <td>Tingkat kedetailan data spasial (misal: skala representasi).</td>
                </tr>
                <tr>
                    <td><strong>Lineage</strong></td>
                    <td>Informasi tentang sejarah asal mula data dan proses yang telah dilaluinya.</td>
                </tr>
                <tr>
                    <td><strong>Point of Contact</strong></td>
                    <td>Pihak atau instansi yang bertanggung jawab atas dataset.</td>
                </tr>
            </tbody>
        </table>

        <h2>Mengapa ini penting?</h2>
        <p>Penerapan metadata berstandar ini memastikan interoperabilitas data antar instansi (memudahkan berbagi pakai data) dan memberikan keyakinan kepada pengguna terkait akurasi dan konteks data sebelum digunakan dalam pengambilan keputusan atau analisis.</p>
    </div>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/filament/pages/api-importer.blade.php

```blade
<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-start gap-4">
            <x-filament::button type="submit" icon="heroicon-m-arrow-down-tray" color="emerald" size="lg">
                🚀 Mulai Tarik Data via API
            </x-filament::button>
        </div>
    </form>

    <div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <h3 class="text-lg font-bold text-emerald-700 dark:text-emerald-400 mb-3 flex items-center gap-2">
            ℹ️ Petunjuk Penarikan Data Spasial via API
        </h3>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
            <li>• <strong>Endpoint API Aceh Default:</strong> <code>https://sig.acehprov.go.id/api/v2/datasets</code> (Otomatis menarik ~143 dataset publik SIG Aceh).</li>
            <li>• <strong>Endpoint API Kebencanaan BNPB:</strong> <code>https://sig.acehprov.go.id/api/v2/external/bnpb-disaster</code> (Menarik data rawan bencana tsunami & banjir).</li>
            <li>• <strong>Custom API Endpoint:</strong> Anda dapat memasukkan URL API GeoJSON / REST API publik mana saja untuk mengintegrasikan data spasial ke dalam geoportal PetaKita Aceh.</li>
        </ul>
    </div>
</x-filament-panels::page>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/filament/pages/dataset-analytics.blade.php

```blade
<x-filament-panels::page>
    <div class="space-y-6">
        @if (count($this->getHeaderWidgets()))
            <x-filament-widgets::widgets
                :columns="$this->getHeaderWidgetsColumns()"
                :data="$this->getWidgetData()"
                :widgets="$this->getVisibleHeaderWidgets()"
            />
        @endif
    </div>
</x-filament-panels::page>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/story-map.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $storyMap->title }} — Story Maps Aceh</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <style>
        :root {
            --bg-base: #f4f6fb;
            --bg-surface: #eef1f7;
            --bg-card: #ffffff;
            --accent: #1a7f4f;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --border: rgba(0,0,0,0.08);
            --font-main: 'Inter', sans-serif;
            --font-display: 'Space Grotesk', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: var(--font-main);
            background: var(--bg-base);
            color: var(--text-primary);
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* Nav */
        .story-nav {
            position: fixed;
            top: 0; left: 0; width: 100%;
            padding: 16px 32px;
            background: linear-gradient(to bottom, rgba(244,246,251,0.95), transparent);
            z-index: 1000;
            display: flex; justify-content: space-between; align-items: center;
        }
        .nav-logo { font-family: var(--font-display); font-weight: 700; font-size: 16px; color: var(--text-primary); text-decoration: none; }
        .nav-logo span { color: var(--accent); }
        .btn-back { font-size: 13px; font-weight: 600; color: var(--text-secondary); text-decoration: none; border: 1px solid var(--border); padding: 6px 14px; border-radius: 8px; background: rgba(255,255,255,0.8); backdrop-filter: blur(5px); transition: 0.2s; }
        .btn-back:hover { color: var(--accent); border-color: var(--accent); }

        /* Layout Split */
        .story-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Narrative Side (Scrollable) */
        .story-narrative {
            width: 45%;
            padding: 120px 0; /* space for header & footer */
            z-index: 10;
        }

        .story-header {
            padding: 0 60px 80px;
        }
        .story-title {
            font-family: var(--font-display);
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .story-meta {
            display: flex; gap: 16px; font-size: 13px; color: var(--text-secondary);
            border-bottom: 1px solid var(--border); padding-bottom: 24px;
        }

        /* Sections */
        .section-block {
            padding: 60px;
            margin-bottom: 120px;
            transition: opacity 0.5s, transform 0.5s;
            opacity: 0.3;
        }
        .section-block.is-active {
            opacity: 1;
        }
        .section-text {
            font-size: 17px;
            color: var(--text-primary);
        }
        .section-media {
            margin-top: 24px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .section-media img { width: 100%; display: block; }

        /* Map Side (Sticky) */
        .story-map-container {
            width: 55%;
            position: fixed;
            top: 0; right: 0;
            height: 100vh;
            border-left: 1px solid var(--border);
        }
        #map { width: 100%; height: 100%; background: #e8edf0; }

        .leaflet-container { font-family: var(--font-main); }
        .leaflet-control-zoom a { background: var(--bg-card) !important; color: var(--text-primary) !important; border-color: var(--border) !important; }

        @media (max-width: 900px) {
            .story-layout { flex-direction: column; }
            .story-narrative { width: 100%; padding: 80px 0; background: rgba(244,246,251,0.85); backdrop-filter: blur(10px); }
            .section-block { padding: 40px 24px; margin-bottom: 60vh; }
            .story-header { padding: 0 24px 60px; }
            .story-map-container { width: 100%; z-index: -1; }
        }
    </style>
</head>
<body>

    <nav class="story-nav">
        <a href="/" class="nav-logo">PetaKita <span>Aceh</span></a>
        <a href="/map" class="btn-back">← Kembali ke Peta</a>
    </nav>

    <div class="story-layout">
        <!-- Text Narrative (Left) -->
        <div class="story-narrative">
            <div class="story-header">
                <h1 class="story-title">{{ $storyMap->title }}</h1>
                <div class="story-meta">
                    <div>Penulis: {{ $storyMap->author->name ?? 'Admin' }}</div>
                    <div>Dipublikasikan: {{ $storyMap->published_at ? \Carbon\Carbon::parse($storyMap->published_at)->format('d M Y') : 'Draft' }}</div>
                </div>
            </div>

            <div id="sections-container">
                @foreach($storyMap->sections->sortBy('order') as $index => $section)
                    <div class="section-block" id="section-{{ $section->id }}" data-map-state="{{ $section->map_state_json }}">
                        <div class="section-text">
                            {!! nl2br(e($section->narrative_text)) !!}
                        </div>
                        @if($section->media_path)
                        <div class="section-media">
                            <img src="{{ Storage::url($section->media_path) }}" alt="Media pendukung">
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div style="padding: 100px 60px; text-align: center; color: var(--text-secondary); font-size: 14px;">
                *** Akhir dari cerita ***
            </div>
        </div>

        <!-- Map (Right) -->
        <div class="story-map-container">
            <div id="map"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        // Init Map
        const map = L.map('map', { zoomControl: false }).setView([5.5483, 95.3238], 8);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; CARTO'
        }).addTo(map);

        // Intersection Observer for Scroll-telling
        const sectionBlocks = document.querySelectorAll('.section-block');
        let currentActiveId = null;

        const observerOptions = {
            root: null,
            rootMargin: '-40% 0px -40% 0px', // Trigger when block is near middle of screen
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const block = entry.target;
                    
                    // Style update
                    sectionBlocks.forEach(b => b.classList.remove('is-active'));
                    block.classList.add('is-active');

                    // Map Update
                    const stateJson = block.getAttribute('data-map-state');
                    if (stateJson) {
                        try {
                            const state = JSON.parse(stateJson);
                            
                            // Fly to coordinates if available
                            if (state.center && state.zoom) {
                                map.flyTo([state.center.lat, state.center.lng], state.zoom, {
                                    animate: true,
                                    duration: 1.5
                                });
                            }
                            
                            // Note: In a full implementation, this is where we would also fetch
                            // and toggle specific layers based on `state.active_layers` array.

                        } catch(e) {
                            console.error("Invalid map state JSON", e);
                        }
                    }
                }
            });
        }, observerOptions);

        // Observe all sections
        sectionBlocks.forEach(block => observer.observe(block));

        // Initial setup for first section if exists
        if (sectionBlocks.length > 0) {
            sectionBlocks[0].classList.add('is-active');
        }

    </script>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/story-maps/index.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Story Maps - PetaKita Aceh</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; background-color: #f4f6fb; }
        
        /* Header CSS inspired by catalog */
        .header {
            background: #ffffff;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { font-size: 24px; }
        .logo-text { font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 800; color: #111827; }
        .logo-text span { color: #198754; font-weight: 900; }
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { color: #6b7280; font-weight: 500; font-size: 14px; text-decoration: none; transition: color 0.2s; padding: 24px 0; border-bottom: 2px solid transparent; }
        .nav-links a:hover { color: #198754; }
        .nav-links a.active { color: #198754; border-bottom-color: #198754; }
        .btn-login { background: #f3f4f6; color: #374151; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none; transition: all 0.2s; }
        .btn-login:hover { background: #e5e7eb; color: #111827; }

        @media (max-width: 768px) {
            .header { padding: 0 20px; }
            .nav-links { display: none; } /* Simplified for mobile */
        }
    </style>
</head>
<body>

    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <div class="logo-icon">🗺️</div>
            <div class="logo-text">
                PetaKita<span>Aceh</span>
            </div>
        </a>
        <nav class="nav-links">
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ route('katalog.index') }}">Katalog Data</a>
            <a href="{{ route('tematik.index') }}">Peta Tematik</a>
            <a href="{{ route('story-maps.index') }}" class="active">Story Maps</a>
        </nav>
        <div class="nav-actions">
            <a href="/admin" class="btn-login">Login Admin</a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8 max-w-6xl mt-6">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Story Maps Aceh (Peta Tematik Naratif)</h1>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Jelajahi berbagai cerita dan laporan interaktif berbasis ruang dari berbagai daerah di Aceh.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($storyMaps as $storyMap)
            <a href="{{ $storyMap->url ?? route('story-maps.show', $storyMap->slug) }}" @if($storyMap->url) target="_blank" rel="noopener noreferrer" @endif class="flex flex-col rounded-2xl shadow-lg overflow-hidden bg-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex-shrink-0 h-48 w-full bg-gray-200 overflow-hidden relative">
                    @if($storyMap->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($storyMap->cover_image))
                        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="{{ asset('storage/' . $storyMap->cover_image) }}" alt="{{ $storyMap->title }}">
                    @else
                        <div class="flex items-center justify-center h-full w-full bg-emerald-100 text-emerald-500">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                        Story Map
                    </div>
                </div>
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-emerald-600 mb-1">
                            {{ $storyMap->author->name ?? 'Pemerintah Aceh' }}
                        </p>
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                            {{ $storyMap->title }}
                        </h3>
                    </div>
                    <div class="mt-4 flex items-center">
                        <div class="text-sm text-gray-500 flex items-center">
                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $storyMap->published_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full py-20 text-center border-2 border-dashed border-gray-300 rounded-xl">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada Story Maps</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada publikasi story maps yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-10">
            {{ $storyMaps->links() }}
        </div>
    </div>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/story-maps/show.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $storyMap->title }} - Story Map PetaKita Aceh</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body { margin: 0; padding: 0; overflow: hidden; font-family: 'Inter', system-ui, sans-serif; }
        
        #story-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        #narrative-pane {
            width: 40%;
            height: 100%;
            overflow-y: scroll;
            scroll-behavior: smooth;
            position: relative;
            z-index: 10;
            background: #ffffff;
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
        }

        #map-pane {
            width: 60%;
            height: 100%;
            position: relative;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* Narrative Sections */
        .story-section {
            padding: 40vh 40px;
            margin: 0;
            border-bottom: 1px solid #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: 0.3;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease;
            transform: translateY(20px);
        }

        .story-section.is-active {
            opacity: 1;
            transform: translateY(0);
        }

        .story-section img {
            max-width: 100%;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .prose p { margin-bottom: 1em; line-height: 1.7; color: #374151; font-size: 1.125rem; }
        .prose h1, .prose h2, .prose h3 { color: #111827; font-weight: 800; margin-bottom: 0.5em; }
        
        /* Progress Bar */
        #progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 40%;
            height: 4px;
            background: #10b981;
            transform-origin: left;
            transform: scaleX(0);
            z-index: 50;
        }

        @media (max-width: 768px) {
            #story-container { flex-direction: column-reverse; }
            #narrative-pane { width: 100%; height: 50%; box-shadow: 0 -5px 15px rgba(0,0,0,0.1); }
            #map-pane { width: 100%; height: 50%; }
            #progress-bar { width: 100%; }
            .story-section { padding: 20vh 20px; min-height: 50vh; }
        }
    </style>
</head>
<body>

    <div id="progress-bar"></div>

    <div id="story-container">
        <!-- Left Pane: Narrative -->
        <div id="narrative-pane">
            
            <!-- Cover Section -->
            <div class="story-section is-active" id="section-cover" data-map-state='{"lat": 4.695, "lng": 96.749, "zoom": 8}'>
                <div class="mb-4">
                    <a href="{{ route('story-maps.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Katalog
                    </a>
                </div>
                
                @if($storyMap->cover_image)
                    <img src="{{ asset('storage/' . $storyMap->cover_image) }}" alt="Cover" class="w-full h-64 object-cover rounded-xl shadow-md mb-6">
                @endif
                
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $storyMap->title }}</h1>
                
                <div class="flex items-center text-gray-500 text-sm mt-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $storyMap->author->name ?? 'Admin' }}
                    </div>
                    <span class="mx-3">•</span>
                    <div>{{ $storyMap->published_at->format('d M Y') }}</div>
                </div>
                
                <div class="mt-12 text-center text-gray-400 animate-bounce">
                    <p class="text-sm uppercase tracking-widest font-semibold mb-2">Scroll untuk memulai</p>
                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
            </div>

            <!-- Sections -->
            @foreach($storyMap->sections as $index => $section)
            <div class="story-section" id="section-{{ $index }}" data-map-state='{{ json_encode($section->map_state_json) }}'>
                
                @if($section->media_path)
                    <img src="{{ asset('storage/' . $section->media_path) }}" alt="Media" class="w-full rounded-xl shadow-md mb-6">
                @endif
                
                <div class="prose prose-lg prose-emerald max-w-none">
                    {!! $section->narrative_text !!}
                </div>
                
            </div>
            @endforeach
            
            <div style="height: 30vh;"></div> <!-- Bottom padding -->
        </div>

        <!-- Right Pane: Map -->
        <div id="map-pane">
            <div id="map"></div>
            <!-- Optional: Map Legend/Overlay could go here -->
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Inisialisasi Peta
        const map = L.map('map', {
            zoomControl: false // Disable default zoom to keep it cinematic
        }).setView([4.695, 96.749], 8);

        L.control.zoom({ position: 'topright' }).addTo(map);

        // Basemap (Dark mode aesthetic for story maps is usually better)
        // Basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Fetching batas wilayah (Real Spatial Data)
        // 1. Batas Kabupaten/Kota
        fetch('/api/layers/1/geojson')
            .then(res => res.json())
            .then(data => {
                if (data && data.features) {
                    L.geoJSON(data, {
                        style: {
                            color: '#0284c7', // Biru Kabupaten
                            weight: 2.5,
                            fillOpacity: 0.05,
                            dashArray: '5, 5'
                        }
                    }).addTo(map);
                }
            })
            .catch(err => console.error('Gagal memuat batas kabupaten:', err));

        // 2. Batas Kecamatan
        fetch('/api/layers/2/geojson')
            .then(res => res.json())
            .then(data => {
                if (data && data.features) {
                    L.geoJSON(data, {
                        style: {
                            color: '#10b981', // Hijau Kecamatan
                            weight: 1,
                            fillOpacity: 0.02
                        }
                    }).addTo(map);
                }
            })
            .catch(err => console.error('Gagal memuat batas kecamatan:', err));

        // Logika Story Map (Intersection Observer)
        const sections = document.querySelectorAll('.story-section');
        const narrativePane = document.getElementById('narrative-pane');
        const progressBar = document.getElementById('progress-bar');

        // Update Progress Bar
        narrativePane.addEventListener('scroll', () => {
            const scrollTop = narrativePane.scrollTop;
            const scrollHeight = narrativePane.scrollHeight - narrativePane.clientHeight;
            const progress = scrollTop / scrollHeight;
            progressBar.style.transform = `scaleX(${progress})`;
        });

        const observerOptions = {
            root: narrativePane,
            rootMargin: '-40% 0px -40% 0px', // Memicu ketika section berada di tengah (20% tengah layar)
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Activate section
                    sections.forEach(sec => sec.classList.remove('is-active'));
                    entry.target.classList.add('is-active');

                    // Gerakkan peta (flyTo)
                    const mapStateRaw = entry.target.getAttribute('data-map-state');
                    if (mapStateRaw) {
                        try {
                            const state = JSON.parse(mapStateRaw);
                            if (state && state.lat && state.lng && state.zoom) {
                                map.flyTo([state.lat, state.lng], state.zoom, {
                                    animate: true,
                                    duration: 2 // cinematic pan
                                });
                            }
                        } catch (e) {
                            console.error("Invalid map state JSON", e);
                        }
                    }
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
        
        // Load initial state
        setTimeout(() => {
            const firstState = sections[0].getAttribute('data-map-state');
            if(firstState) {
                const state = JSON.parse(firstState);
                if (state && state.lat && state.lng && state.zoom) {
                    map.setView([state.lat, state.lng], state.zoom);
                }
            }
        }, 100);

    </script>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/tematik/index.blade.php

```blade
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

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/viewer.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaKita Aceh — Interactive WebGIS & Spatial Viewer</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;900&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-measure/dist/leaflet-measure.css" />

    <style>
        :root {
            --primary: #198754;
            --primary-hover: #157347;
            --primary-light: #e8f5ee;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --bg-white: #ffffff;
            --bg-body: #f1f3f5;
            --border: #e5e7eb;
            --sidebar-width: 340px;
            --shadow: 0 4px 14px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --font-main: 'Inter', sans-serif;
            --font-display: 'Outfit', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-body);
            color: var(--text-dark);
            overflow: hidden;
            display: flex;
            height: 100vh;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(107, 114, 128, 0.3); border-radius: var(--radius-md); }
        ::-webkit-scrollbar-thumb:hover { background: rgba(107, 114, 128, 0.5); }
        * { scrollbar-width: thin; scrollbar-color: rgba(107, 114, 128, 0.3) transparent; }

        /* Focus & Micro-interactions */
        button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
        .nav-btn:active, .tool-btn:active, .btn-pilih-mapset:active {
            transform: scale(0.97);
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            background: #f8f9fa;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            position: relative;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        }

        .sidebar-header {
            padding: 18px 20px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 17px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .logo span { color: var(--text-dark); }

        .sidebar-search {
            padding: 16px 20px;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .search-box {
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-box input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(25,135,84,0.12); }
        .search-box svg.search-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 18px; height: 18px; color: var(--text-muted); pointer-events: none;
        }
        .search-box button {
            position: absolute; right: 5px; top: 5px; bottom: 5px;
            background: var(--primary); color: white; border: none; border-radius: 6px;
            padding: 0 14px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .search-box button:hover { background: var(--primary-hover); }
        
        /* Autocomplete Dropdown */
        .search-autocomplete {
            position: absolute; top: 100%; left: 0; right: 0; margin-top: 6px;
            background: white; border: 1px solid var(--border); border-radius: 8px;
            box-shadow: var(--shadow-lg); z-index: 1050; max-height: 360px; overflow-y: auto;
        }
        .autocomplete-header {
            padding: 10px 16px; font-weight: 700; font-size: 12px; color: var(--text-muted);
            background: #f1f3f5; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px;
        }
        .autocomplete-item {
            padding: 12px 16px; font-size: 13px; color: var(--text-dark); cursor: pointer;
            border-bottom: 1px solid var(--border); transition: 0.2s; line-height: 1.4; display: flex; align-items: center; gap: 8px;
        }
        .autocomplete-item:last-child { border-bottom: none; }
        .autocomplete-item:hover { background: var(--primary-light); color: var(--primary); }

        .sidebar-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Mapset Widget */
        .mapset-widget {
            background: white;
            border-radius: var(--radius-md);
            padding: 14px 12px;
            text-align: center;
            border: 1px dashed var(--border);
            margin-bottom: 20px;
        }
        .mapset-icon {
            width: 36px; height: 36px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px;
        }
        .mapset-icon svg { width: 18px; height: 18px; }
        .mapset-status {
            font-size: 14px; font-weight: 700; margin-bottom: 4px; color: var(--text-dark);
        }
        .mapset-desc {
            font-size: 11px; color: var(--text-muted); margin-bottom: 12px; line-height: 1.3;
        }
        .btn-pilih-mapset {
            background: var(--primary);
            color: white; border: none; padding: 8px 16px; border-radius: var(--radius-md);
            font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; transition: 0.2s;
        }
        .btn-pilih-mapset:hover { background: var(--primary-hover); }

        /* Sidebar Layer List */
        .sidebar-layer-list { margin-bottom: 24px; }
        .layer-item { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-size: 13px; }
        
        /* Custom Checkbox */
        .checkbox-container { position: relative; cursor: pointer; font-size: 13px; user-select: none; display: flex; align-items: center; gap: 8px; color: var(--text-dark); }
        .checkbox-container input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .checkmark { height: 18px; width: 18px; background-color: white; border: 1px solid var(--border); border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .checkbox-container:hover input ~ .checkmark { border-color: var(--primary); }
        .checkbox-container input:checked ~ .checkmark { background-color: var(--primary); border-color: var(--primary); }
        .checkmark:after { content: "✓"; color: white; font-weight: 900; font-size: 11px; display: none; }
        .checkbox-container input:checked ~ .checkmark:after { display: block; }
        .checkbox-container input:checked ~ .layer-name { font-weight: 600; }

        /* Measurement Tools Widget */
        .tools-widget {
            background: white;
            border-radius: 10px;
            padding: 16px;
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }
        .tools-grid {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            justify-content: space-between;
        }
        .tool-btn {
            flex: 1; height: 44px;
            background: #f8f9fa;
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-dark); transition: 0.2s; font-size: 12px; font-weight: 600; gap: 6px;
        }
        .tool-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

        /* MAP AREA */
        #map-container {
            flex: 1;
            position: relative;
            background: #e5e7eb;
        }
        #map {
            width: 100%; height: 100%;
            z-index: 1;
        }

        /* Top Right Nav over map */
        .top-right-nav {
            position: absolute; top: 16px; right: 16px; z-index: 1000;
            display: flex; gap: 8px;
        }
        .leaflet-top.leaflet-right {
            top: 64px !important;
        }
        .nav-btn {
            background: white; border: 1px solid var(--border); padding: 8px 16px;
            border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;
            box-shadow: var(--shadow); color: var(--text-dark); text-decoration: none;
            display: flex; align-items: center; gap: 6px; transition: 0.2s;
        }
        .nav-btn:hover { background: #f8f9fa; transform: translateY(-1px); }

        /* BASEMAP SELECTOR MODAL / PANEL */
        .basemap-picker-panel {
            position: absolute; bottom: 64px; right: 16px; z-index: 1000;
            background: white; border-radius: 12px; padding: 14px;
            box-shadow: var(--shadow-lg); border: 1px solid var(--border);
            display: none; width: 280px;
        }
        .basemap-picker-panel.show { display: block; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .basemap-picker-title { font-weight: 700; font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px; }
        .basemap-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .basemap-option {
            border: 2px solid var(--border); border-radius: 8px; padding: 8px; cursor: pointer;
            text-align: center; font-size: 12px; font-weight: 600; transition: all 0.2s; background: #f8f9fa;
        }
        .basemap-option:hover, .basemap-option.active { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
        .basemap-option .icon { font-size: 20px; display: block; margin-bottom: 4px; }

        /* Bottom Controls over Map */
        .bottom-map-controls {
            position: absolute; bottom: 16px; right: 16px; z-index: 1000;
            display: flex; gap: 10px; align-items: center;
        }
        .coord-display {
            background: white; border-radius: 20px; padding: 6px 14px;
            font-size: 12px; font-weight: 500; box-shadow: var(--shadow); border: 1px solid var(--border);
        }
        .basemap-toggle {
            background: white; border-radius: 20px; padding: 6px 16px; cursor: pointer;
            font-size: 12px; font-weight: 600; box-shadow: var(--shadow); border: 1px solid var(--border);
            display: flex; align-items: center; gap: 6px; transition: 0.2s;
        }
        .basemap-toggle:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }

        /* SPATIAL ATTRIBUTE INSPECTOR SIDE SHEET */
        .attribute-inspector {
            position: absolute; top: 70px; right: 16px; bottom: 70px; width: 360px;
            background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);
            z-index: 1000; display: none; flex-direction: column; overflow: hidden;
            border: 1px solid var(--border);
        }
        .attribute-inspector.show { display: flex; animation: slideIn 0.25s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        
        .inspector-header {
            padding: 16px 20px; background: var(--primary); color: white;
            display: flex; justify-content: space-between; align-items: center;
        }
        .inspector-title { font-family: var(--font-display); font-weight: 700; font-size: 15px; }
        .inspector-subtitle { font-size: 11px; opacity: 0.9; margin-top: 2px; }
        .inspector-close { background: none; border: none; color: white; cursor: pointer; font-size: 18px; opacity: 0.8; }
        .inspector-close:hover { opacity: 1; }

        .inspector-body {
            flex: 1; overflow-y: auto; padding: 16px;
        }
        .attr-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .attr-table tr { border-bottom: 1px solid var(--border); }
        .attr-table tr:last-child { border-bottom: none; }
        .attr-table th { text-align: left; padding: 8px 6px; color: var(--text-muted); font-weight: 600; width: 40%; font-size: 12px; }
        .attr-table td { padding: 8px 6px; color: var(--text-dark); font-weight: 600; word-break: break-word; }

        /* Modals */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999;
            visibility: hidden; pointer-events: none;
            display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s, visibility 0.3s;
        }
        .modal-overlay.show { visibility: visible; pointer-events: auto; opacity: 1; }
        .modal-content {
            background: white; width: 95%; max-width: 1000px; height: 82vh;
            border-radius: 14px; display: flex; flex-direction: column; overflow: hidden;
            box-shadow: var(--shadow-lg); transform: translateY(20px); transition: transform 0.3s;
        }
        .modal-overlay.show .modal-content { transform: translateY(0); }
        
        .modal-header {
            padding: 18px 24px; border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
        }
        .modal-title { font-family: var(--font-display); font-size: 18px; font-weight: 700; }
        .btn-close { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; border-radius: 4px; }
        .btn-close:hover { background: #f3f4f6; color: var(--text-dark); }
        
        .modal-body { display: flex; flex: 1; overflow: hidden; }
        .modal-sidebar { width: 380px; border-right: 1px solid var(--border); display: flex; flex-direction: column; background: #fdfdfd; }
        .modal-filters { padding: 16px; border-bottom: 1px solid var(--border); display: flex; flex-direction: column; gap: 10px; }
        .filter-row { display: flex; gap: 8px; }
        .filter-select { flex: 1; padding: 8px; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; color: var(--primary); font-weight: 500; outline: none; }
        
        .mapset-list { flex: 1; overflow-y: auto; padding: 12px; }
        .mapset-item {
            background: white; border: 1px solid var(--border); border-radius: 8px; padding: 12px; margin-bottom: 8px;
            display: flex; gap: 12px; cursor: pointer; transition: 0.2s; align-items: center;
        }
        .mapset-item:hover { border-color: var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .mapset-item.selected { border-color: var(--primary); background: var(--primary-light); }
        .mapset-item-icon { width: 38px; height: 38px; background: #f1f3f5; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .mapset-item-info { flex: 1; }
        .mapset-item-title { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
        .mapset-item-org { font-size: 11px; color: var(--text-muted); }

        .modal-preview { flex: 1; display: flex; align-items: center; justify-content: center; background: #f8f9fa; padding: 24px; }
        .empty-preview { text-align: center; color: var(--text-muted); }

        /* Leaflet Overrides */
        .leaflet-control-zoom { border: none !important; box-shadow: var(--shadow) !important; margin-right: 20px !important; margin-top: 20px !important; }
        .leaflet-control-zoom a { color: var(--text-dark) !important; width: 44px !important; height: 44px !important; line-height: 44px !important; border-radius: 8px !important; margin-bottom: 4px !important; }
        .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: var(--shadow-lg); padding: 0; overflow: hidden; }
        .leaflet-popup-content { margin: 16px 20px; line-height: 1.5; }
        .popup-title { font-weight: 800; font-size: 14px; text-transform: uppercase; color: var(--primary); margin-bottom: 4px; padding-right: 20px;}
        .popup-subtitle { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;}
        .popup-prop { font-size: 12px; display: grid; grid-template-columns: minmax(80px, auto) 1fr; gap: 8px; margin-bottom: 6px; color: var(--text-dark); border-bottom: 1px dashed var(--border); padding-bottom: 4px;}
        .popup-prop:last-child { border-bottom: none; }
        .popup-prop span { color: var(--text-muted); font-weight: 500;}
        .popup-prop strong { word-break: break-word; color: var(--text-dark); }
        
        .loader-wrapper {
            position: absolute; inset: 0; background: white; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.4s;
        }
        .spinner { width: 42px; height: 42px; border: 4px solid var(--primary-light); border-top-color: var(--primary); border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 16px; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        
        #toast-container { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10000; display: flex; flex-direction: column; gap: 8px; pointer-events: none; }
        .toast-msg { background: #f59e0b; color: white; padding: 10px 16px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 13px; font-weight: 600; opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; gap: 8px; pointer-events: auto; }
        .layer-spinner { width: 14px; height: 14px; border: 2px solid var(--primary-light); border-top-color: var(--primary); border-radius: 50%; animation: spin 0.8s linear infinite; }
        
        @media print {
            #sidebar, .top-right-nav, .basemap-picker-panel, .modal-overlay, .loader-wrapper, .leaflet-control-container {
                display: none !important;
            }
            #map-container {
                width: 100% !important;
                height: 100vh !important;
            }
            #attribute-inspector {
                right: 10px !important;
                top: 10px !important;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
        }
        
        /* MOBILE RESPONSIVE UX */
        .mobile-toggle-btn {
            display: none;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: white;
            border: 2px solid rgba(0,0,0,0.2);
            border-radius: 4px;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 1px 5px rgba(0,0,0,0.65);
            color: #333;
        }
        .mobile-toggle-btn:hover { background: #f4f4f4; }
        
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 768px) {
            body.inspector-open .legend-widget,
            body.inspector-open .bottom-map-controls {
                transform: translateY(150px) !important;
                opacity: 0 !important;
                pointer-events: none !important;
            }
            body.inspector-open #toast-container {
                transform: translate(-50%, 150px) !important;
                opacity: 0 !important;
                pointer-events: none !important;
            }
            .legend-widget, .bottom-map-controls, #toast-container {
                transition: transform 0.3s ease, opacity 0.3s ease !important;
            }
            body {
                flex-direction: column;
            }
            #sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                width: 85%;
                max-width: 340px;
                transition: left 0.3s ease;
                box-shadow: var(--shadow-lg);
            }
            #sidebar.open {
                left: 0;
            }
            .mobile-toggle-btn {
                display: flex !important;
            }
            .attribute-inspector {
                top: auto !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                max-height: 45vh !important;
                border-radius: 16px 16px 0 0 !important;
                box-shadow: 0 -4px 16px rgba(0,0,0,0.15) !important;
            }
            .leaflet-top.leaflet-left {
                top: 50px; 
            }
            .legend-widget {
                bottom: 20px !important;
                left: 10px !important;
                max-width: 200px !important;
                padding: 12px !important;
            }
            .top-right-nav {
                top: 10px !important;
                right: 10px !important;
                gap: 6px !important;
            }
            .top-right-nav .nav-btn {
                padding: 6px 10px !important;
                font-size: 11px !important;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>

    <!-- Toast Notification Container -->
    <div id="toast-container"></div>

    <!-- Page Loader -->
    <div class="loader-wrapper" id="page-loader">
        <div class="spinner"></div>
        <div style="font-weight:700; font-size:15px; color:var(--text-dark)">Memuat Peta Kita Aceh...</div>
        <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Menyiapkan dataset spasial dan layer peta</div>
    </div>

    <!-- LEFT SIDEBAR -->
    <div id="sidebar">
        <div class="sidebar-header">
            <a href="/" class="logo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                PetaKita <span>Aceh</span>
            </a>
            <a href="/katalog" style="font-size:12px; color:var(--primary); font-weight:600; text-decoration:none;">Katalog Data</a>
        </div>

        <!-- SEARCH BAR: DESA, KECAMATAN, ALAMAT -->
        <div class="sidebar-search">
            <div class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" class="search-input" id="sidebar-search-input" placeholder="Cari Desa, Kecamatan, Alamat..." aria-label="Pencarian Desa, Kecamatan, Alamat">
                <button class="search-btn" aria-label="Cari Lokasi">Cari</button>
                
                <!-- Autocomplete Dropdown -->
                <div id="search-autocomplete" class="search-autocomplete" style="display:none;">
                    <div class="autocomplete-header">Hasil Lokasi & Data (<span id="autocomplete-count">0</span>)</div>
                    <div id="autocomplete-list"></div>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <!-- FILTER WILAYAH ADMINISTRASI -->
            <div class="section-title">Filter Wilayah Administrasi</div>
            <div style="background: white; border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; margin-bottom: 24px; display: flex; flex-direction: column; gap: 10px;">
                <div>
                    <label for="filter-kabupaten" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; display: block;">Kabupaten / Kota</label>
                    <select id="filter-kabupaten" aria-label="Filter Kabupaten atau Kota" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-weight: 500; outline: none; background: #f8f9fa; cursor: pointer; color: var(--text-dark); transition: border-color 0.2s;">
                        <option value="">-- Pilih Kabupaten/Kota --</option>
                    </select>
                </div>
                <div>
                    <label for="filter-kecamatan" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; display: block;">Kecamatan</label>
                    <select id="filter-kecamatan" aria-label="Filter Kecamatan" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-weight: 500; outline: none; background: #f8f9fa; cursor: pointer; color: var(--text-dark); transition: border-color 0.2s;" disabled>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div>
                    <label for="filter-desa" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; display: block;">Desa / Kelurahan</label>
                    <select id="filter-desa" aria-label="Filter Desa atau Kelurahan" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-weight: 500; outline: none; background: #f8f9fa; cursor: pointer; color: var(--text-dark); transition: border-color 0.2s;" disabled>
                        <option value="">-- Pilih Desa/Kelurahan --</option>
                    </select>
                </div>
            </div>

            <div class="section-title">Dataset Spasial Active</div>
            <div class="mapset-widget">
                <div class="mapset-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div class="mapset-status" id="active-mapset-title">Pilih Mapset Spasial</div>
                <div class="mapset-desc" id="active-mapset-desc">Klik tombol di bawah untuk memilih layer data geospasial Provinsi Aceh.</div>
                <button class="btn-pilih-mapset" onclick="openModal()">🗺️ Pilih Mapset Data</button>
            </div>
            
            <div class="sidebar-layer-list" id="sidebar-layer-list" style="display:none;">
                <div class="section-title">Layer Data Aktif</div>
                <div id="layer-items-container"></div>
            </div>

            <div class="section-title">Alat Pengukuran & Cetak Peta</div>
            <div class="tools-widget">
                <div class="tools-grid">
                    <button class="tool-btn" id="tool-measure-dist" title="Ukur Jarak">📏 Jarak</button>
                    <button class="tool-btn" id="tool-measure-area" title="Ukur Luas">📐 Luas</button>
                    <button class="tool-btn" id="tool-fullscreen" title="Layar Penuh">🖥️ Fullscreen</button>
                    <button class="tool-btn" onclick="printMap()" title="Cetak Peta">🖨️ Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN MAP AREA -->
    <div id="map-container">
        <!-- MOBILE SIDEBAR BACKDROP -->
        <div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleMobileSidebar()"></div>
        
        <!-- MOBILE SIDEBAR TOGGLE -->
        <button id="mobile-sidebar-toggle" class="mobile-toggle-btn" aria-label="Buka Sidebar" aria-expanded="false" onclick="toggleMobileSidebar()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <div class="top-right-nav">
            <button class="nav-btn" onclick="openDisasterModal()" style="background:#198754; color:white; border:none; cursor:pointer;">
                📰 Berita & Tanggap Bencana
            </button>
            <a href="/katalog" class="nav-btn">📂 Katalog</a>
            <a href="/" class="nav-btn">🏠 Beranda</a>
        </div>
        
        <div id="map"></div>

        <!-- SPATIAL ATTRIBUTE INSPECTOR SIDE PANEL -->
        <div class="attribute-inspector" id="attribute-inspector">
            <div class="inspector-header">
                <div>
                    <div class="inspector-title" id="inspector-layer-name">Detail Atribut Spasial</div>
                    <div class="inspector-subtitle">Provinsi Aceh</div>
                </div>
                <button class="inspector-close" aria-label="Tutup Panel Atribut" onclick="closeInspector()">✕</button>
            </div>
            <div class="inspector-body" id="inspector-body">
                <div style="text-align:center; color:var(--text-muted); padding:30px 10px;">
                    Klik salah satu elemen poligon/titik pada peta untuk melihat isi tabel atribut.
                </div>
            </div>
            <div class="inspector-footer" id="inspector-footer" style="padding:12px; border-top:1px solid #e9ecef; background:#f8f9fa; display:none;">
                <button onclick="exportAttributeCsv()" style="width:100%; font-size:12px; font-weight:700; padding:9px 12px; background:#198754; color:white; border:none; border-radius:6px; cursor:pointer;">
                    📥 Unduh Data Atribut (CSV)
                </button>
            </div>
        </div>

        <!-- BASEMAP PICKER PANEL -->
        <div class="basemap-picker-panel" id="basemap-picker-panel">
            <div class="basemap-picker-title">Pilihan Basemap Peta</div>
            <div class="basemap-grid">
                <div class="basemap-option active" onclick="switchBasemap('osm')">
                    <span class="icon">🗺️</span>
                    Peta Standar
                </div>
                <div class="basemap-option" onclick="switchBasemap('esri')">
                    <span class="icon">🛰️</span>
                    Citra Satelit
                </div>
                <div class="basemap-option" onclick="switchBasemap('topo')">
                    <span class="icon">🏔️</span>
                    Topografi
                </div>
                <div class="basemap-option" onclick="switchBasemap('cartodb_dark')">
                    <span class="icon">🌙</span>
                    Dark Mode
                </div>
            </div>
        </div>

        <!-- BOTTOM CONTROLS OVER MAP -->
        <div class="bottom-map-controls">
            <div class="coord-display" id="coord-display">Lat 0.00000 Long 0.00000</div>
            <div class="basemap-toggle" onclick="toggleBasemapPicker()">
                <span>🗺️ Basemap: <strong id="basemap-label">Peta Standar</strong></span>
            </div>
        </div>
        <!-- LAYER LEGEND WIDGET -->
        <div class="legend-widget" id="legend-widget" style="display:none; position: absolute; bottom: 64px; left: 16px; z-index: 1000; background: white; border-radius: var(--radius-lg); padding: 14px 16px; box-shadow: var(--shadow-lg); border: 1px solid var(--border); width: 220px; max-height: 35vh; overflow-y: auto;">
            <div style="font-weight: 700; font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">Legenda Peta</div>
            <div id="legend-items"></div>
        </div>

    </div>

    <!-- MODAL BERITA & TANGGAP BENCANA ACEH -->
    <div class="modal-overlay" id="disaster-news-modal">
        <div class="modal-content" style="max-width: 680px; max-height: 85vh;">
            <div class="modal-header" style="background:#198754; color:white;">
                <div>
                    <div class="modal-title" style="color:white; font-size:18px;">📰 Berita Kebencanaan & Informasi Tanggap Bencana Aceh</div>
                    <div style="font-size:12px; opacity:0.9; margin-top:2px;">Integrasi Portal Resmi BNPB, BPBA Aceh & BMKG</div>
                </div>
                <button class="btn-close" aria-label="Tutup Modal Berita" onclick="closeDisasterModal()" style="color:white; font-size:20px; padding: 10px;">✕</button>
            </div>
            <div class="modal-body" style="padding: 24px; display: block; overflow-y: auto;">
                <div style="margin-bottom: 20px; background: #e8f5ee; border-left: 4px solid #198754; padding: 14px; border-radius: 8px;">
                    <div style="font-weight: 700; color: #198754; font-size: 14px; margin-bottom: 4px;">🌊 Portal Integrasi Spasial Kebencanaan Aceh</div>
                    <div style="font-size: 13px; color: #333; line-height: 1.5;">
                        Peta rawan bencana pesisir tsunami, banjir bandang, serta informasi peringatan dini cuaca diintegrasikan otomatis dari API resmi versi 2 (sig.acehprov.go.id/api/v2) dan BNPB Indonesia.
                    </div>
                </div>

                <div class="news-feed-list" style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="border: 1px solid #dee2e6; border-radius: 10px; padding: 16px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span style="background: #dc3545; color: white; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700;">PERINGATAN DINI BENCANA</span>
                        <h4 style="font-size: 16px; font-weight: 700; margin: 8px 0 4px; color: #111827;">Peta Kerawanan Tsunami & Pesisir Pantai Aceh (BNPB & BPBA)</h4>
                        <p style="font-size: 13px; color: #6c757d; margin-bottom: 12px;">Pemetaan zona evakuasi tsunami, jalur sirine kedaruratan, serta kawasan lindung pesisir pantai se-Provinsi Aceh.</p>
                        <a href="https://sig.acehprov.go.id/api/v2/external/bnpb-disaster" target="_blank" style="color: #198754; font-weight: 700; text-decoration: none; font-size: 13px;">🔗 Buka API Data Bencana BNPB →</a>
                    </div>

                    <div style="border: 1px solid #dee2e6; border-radius: 10px; padding: 16px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span style="background: #f59e0b; color: white; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700;">INFO BANJIR & BMKG</span>
                        <h4 style="font-size: 16px; font-weight: 700; margin: 8px 0 4px; color: #111827;">Monitoring Potensi Banjir Bandang DAS Aceh Besar & Pidie</h4>
                        <p style="font-size: 13px; color: #6c757d; margin-bottom: 12px;">Pemantauan intensitas curah hujan daerah aliran sungai dan potensi genangan air di kawasan permukiman penduduk.</p>
                        <a href="https://sig.acehprov.go.id" target="_blank" style="color: #198754; font-weight: 700; text-decoration: none; font-size: 13px;">🔗 Kunjungi Portal Resmi SIG Aceh →</a>
                    </div>

                    <div style="border: 1px solid #dee2e6; border-radius: 10px; padding: 16px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span style="background: #0284c7; color: white; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700;">PEMBARUAN KATALOG SPASIAL</span>
                        <h4 style="font-size: 16px; font-weight: 700; margin: 8px 0 4px; color: #111827;">Peta Batas Administrasi Desa, Kecamatan & Kota/Kabupaten</h4>
                        <p style="font-size: 13px; color: #6c757d; margin-bottom: 12px;">Dataset batas administrasi wilayah 23 Kabupaten/Kota dan 290 Kecamatan se-Aceh telah siap diunduh di Katalog Data.</p>
                        <a href="/katalog" style="color: #198754; font-weight: 700; text-decoration: none; font-size: 13px;">🔍 Telusuri Katalog Data Spasial →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KATALOG MAPSET -->
    <div class="modal-overlay" id="mapset-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Katalog Mapset & Layer Spasial</div>
                <button class="btn-close" aria-label="Tutup Katalog Mapset" onclick="closeModal()" style="font-size:20px; padding:10px;">✕</button>
            </div>
            <div class="modal-body">
                <div class="modal-sidebar">
                    <div class="modal-filters">
                        <div class="search-box">
                            <input type="text" id="modal-search-input" placeholder="Cari dataset spasial...">
                        </div>
                        <div class="filter-row">
                            <select class="filter-select" id="modal-filter-org"><option value="">Semua Instansi (OPD)</option></select>
                            <select class="filter-select" id="modal-filter-sort"><option value="">Urutkan A-Z</option><option value="asc">Judul (A-Z)</option><option value="desc">Judul (Z-A)</option></select>
                        </div>
                    </div>
                    <div class="mapset-list" id="modal-mapset-list">
                        <div style="text-align:center; padding:20px; color:var(--text-muted)">Memuat data mapset...</div>
                    </div>
                </div>
                <div class="modal-preview" id="modal-preview-content">
                    <div class="empty-preview" style="display:flex; flex-direction:column; align-items:center; opacity:0.6;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        <h3 style="margin-top:16px; font-size:14px; font-weight:600; color:var(--text-dark);">Belum Ada Mapset Terpilih</h3>
                        <p style="font-size:12px; margin-top:4px;">Pilih salah satu mapset dari daftar untuk melihat detail layer spasial.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-measure/dist/leaflet-measure.js"></script>
    
    <script>
        const initialDatasets = @json(isset($datasets) ? $datasets : []);
        const tematikConfig = @json(isset($tematikConfig) ? $tematikConfig : null);

        // ============================================
        // 1. INITIALIZE MAP & BASEMAPS
        // ============================================
        const urlParamsMap = new URLSearchParams(window.location.search);
        let initLat = 5.5483;
        let initLng = 95.3238;
        let initZoom = 9;

        if (tematikConfig && tematikConfig.map_settings) {
            if (tematikConfig.map_settings.center) {
                initLat = tematikConfig.map_settings.center[0];
                initLng = tematikConfig.map_settings.center[1];
            }
            if (tematikConfig.map_settings.zoom) {
                initZoom = tematikConfig.map_settings.zoom;
            }
        }

        const urlLat = parseFloat(urlParamsMap.get('lat'));
        const urlLng = parseFloat(urlParamsMap.get('lng'));
        const urlZoom = parseInt(urlParamsMap.get('z'));

        if (!isNaN(urlLat) && urlLat >= -90 && urlLat <= 90 && 
            !isNaN(urlLng) && urlLng >= -180 && urlLng <= 180 &&
            !isNaN(urlZoom) && urlZoom >= 0 && urlZoom <= 22) {
            initLat = urlLat;
            initLng = urlLng;
            initZoom = urlZoom;
        }

        const map = L.map('map', {
            zoomControl: false
        }).setView([initLat, initLng], initZoom); 
        
        L.control.zoom({ position: 'topright' }).addTo(map);

        // Coordinate Tracker
        map.on('mousemove', function(e) {
            document.getElementById('coord-display').innerHTML = `Lat ${e.latlng.lat.toFixed(5)} Long ${e.latlng.lng.toFixed(5)}`;
        });

        // Measurement Control
        const measureControl = L.control.measure({
            position: 'topleft',
            primaryLengthUnit: 'kilometers', 
            secondaryLengthUnit: 'meters',
            primaryAreaUnit: 'hectares', 
            secondaryAreaUnit: 'sqmeters',
            activeColor: '#198754',
            completedColor: '#157347'
        });
        measureControl.addTo(map);
        
        document.getElementById('tool-measure-dist').addEventListener('click', function() {
            const btn = document.querySelector('.js-toggle');
            if (btn) btn.click();
        });
        document.getElementById('tool-measure-area').addEventListener('click', function() {
            const btn = document.querySelector('.js-toggle');
            if (btn) btn.click();
        });

        // Fullscreen
        document.getElementById('tool-fullscreen').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        });

        // Basemaps definition
        const basemaps = {
            osm: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }),
            esri: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: '&copy; Esri Satelit' }),
            topo: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenTopoMap' }),
            cartodb_dark: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', { attribution: '&copy; CARTO Dark' })
        };
        let currentBasemapKey = 'osm';
        basemaps.osm.addTo(map);

        const basemapLabels = {
            osm: 'Peta Standar',
            esri: 'Citra Satelit',
            topo: 'Topografi',
            cartodb_dark: 'Dark Mode'
        };

        function toggleBasemapPicker() {
            const panel = document.getElementById('basemap-picker-panel');
            panel.classList.toggle('show');
        }

        function switchBasemap(key) {
            if (!basemaps[key]) return;
            map.removeLayer(basemaps[currentBasemapKey]);
            currentBasemapKey = key;
            basemaps[currentBasemapKey].addTo(map);
            
            document.getElementById('basemap-label').innerText = basemapLabels[key];
            document.querySelectorAll('.basemap-option').forEach(el => el.classList.remove('active'));
            document.getElementById('basemap-picker-panel').classList.remove('show');
        }

        // Close basemap picker on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.basemap-toggle') && !e.target.closest('.basemap-picker-panel')) {
                document.getElementById('basemap-picker-panel').classList.remove('show');
            }
        });


        // ============================================
        // 2. SEARCH & GEOCODING (DESA, KECAMATAN, ALAMAT)
        // ============================================
        const searchInput = document.getElementById('sidebar-search-input');
        const searchBtn = document.querySelector('.search-btn');
        const autocompleteBox = document.getElementById('search-autocomplete');
        const autocompleteList = document.getElementById('autocomplete-list');
        const autocompleteCount = document.getElementById('autocomplete-count');
        
        let searchTimeout = null;

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            if (query.length < 2) {
                autocompleteBox.style.display = 'none';
                return;
            }
            if (searchTimeout) clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchAutocomplete(query);
            }, 350);
        });

        function searchLocalActiveLayers(query) {
            const lower = query.toLowerCase();
            const results = [];
            for (let layerId in activeLayers) {
                activeLayers[layerId].eachLayer(function(layer) {
                    if (layer.feature && layer.feature.properties) {
                        for (let k in layer.feature.properties) {
                            let val = layer.feature.properties[k];
                            if (val && String(val).toLowerCase().includes(lower)) {
                                results.push({ layer: layer, matchVal: String(val) });
                                break;
                            }
                        }
                    }
                });
            }
            return results;
        }

        async function fetchAutocomplete(query) {
            try {
                const localResults = searchLocalActiveLayers(query).slice(0, 4);
                
                // Fetch external Nominatim geocoder API focused on Aceh / Indonesia
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Aceh, Indonesia')}&limit=5`);
                const nominatimData = await response.json();
                
                let combined = [];
                
                // Local spatial features
                localResults.forEach(item => {
                    combined.push({
                        label: `🗺️ Data Peta: ${item.matchVal}`,
                        action: () => {
                            searchInput.value = item.matchVal;
                            autocompleteBox.style.display = 'none';
                            if (item.layer.getLatLng) {
                                map.flyTo(item.layer.getLatLng(), 16, { animate: true, duration: 1.2 });
                            } else if (item.layer.getBounds) {
                                map.fitBounds(item.layer.getBounds());
                            }
                            showFeatureInspector(item.layer.feature.properties, "Layer Peta");
                            setTimeout(() => item.layer.openPopup(), 1300);
                        }
                    });
                });
                
                // Geocoder results (Desa, Kecamatan, Alamat)
                if (nominatimData) {
                    nominatimData.forEach(item => {
                        let prefix = '📍 Alamat';
                        const type = item.type || '';
                        if (type.includes('village') || type.includes('hamlet') || type.includes('administrative')) {
                            prefix = '🏠 Desa / Kelurahan';
                        } else if (type.includes('subdistrict') || type.includes('town') || type.includes('city')) {
                            prefix = '🏛️ Kecamatan / Kota';
                        }
                        
                        combined.push({
                            label: `${prefix}: ${item.display_name}`,
                            action: () => {
                                searchInput.value = item.display_name;
                                autocompleteBox.style.display = 'none';
                                const lat = parseFloat(item.lat);
                                const lon = parseFloat(item.lon);
                                map.flyTo([lat, lon], 15, { animate: true, duration: 1.5 });
                                
                                L.popup()
                                    .setLatLng([lat, lon])
                                    .setContent(`<div class="popup-title">${prefix}</div><div style="font-size:12px; font-weight:600;">${item.display_name}</div>`)
                                    .openOn(map);
                            }
                        });
                    });
                }
                
                if (combined.length > 0) {
                    autocompleteCount.innerText = combined.length;
                    autocompleteList.innerHTML = '';
                    combined.forEach(res => {
                        const div = document.createElement('div');
                        div.className = 'autocomplete-item';
                        div.innerHTML = res.label;
                        div.onclick = res.action;
                        autocompleteList.appendChild(div);
                    });
                    autocompleteBox.style.display = 'block';
                } else {
                    autocompleteBox.style.display = 'none';
                }
            } catch (e) {
                console.error("Geocoding error:", e);
            }
        }

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box')) {
                autocompleteBox.style.display = 'none';
            }
        });

        async function performSearch() {
            const query = searchInput.value.trim();
            if (!query) return;
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Aceh, Indonesia')}&limit=1`);
                const data = await response.json();
                if (data && data.length > 0) {
                    const item = data[0];
                    map.flyTo([parseFloat(item.lat), parseFloat(item.lon)], 15, { animate: true, duration: 1.5 });
                    L.popup()
                        .setLatLng([parseFloat(item.lat), parseFloat(item.lon)])
                        .setContent(`<div class="popup-title">📍 Lokasi Terpilih</div><div style="font-size:12px; font-weight:600;">${item.display_name}</div>`)
                        .openOn(map);
                    autocompleteBox.style.display = 'none';
                } else {
                    alert('Lokasi tidak ditemukan. Coba ketik nama desa atau kecamatan lain.');
                }
            } catch(e) {
                console.error(e);
            }
        }
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') performSearch(); });


        // ============================================
        // 3. SPATIAL ATTRIBUTE INSPECTOR & POPUPS
        // ============================================
        let currentInspectedProperties = null;
        let currentInspectedLayerName = '';

        function formatAttributeKey(key) {
            const keyMap = {
                'namobj': 'Nama Objek / Batas',
                'namws': 'Wilayah Sungai',
                'jnssng': 'Jenis Sungai',
                'klssng': 'Kelas Sungai',
                'remark': 'Keterangan / Sumber',
                'shape_leng': 'Panjang Garis (m)',
                'shape_le_1': 'Panjang Detail',
                'shape__length': 'Panjang Geometri (m)',
                'namdas': 'Nama DAS',
                'fcode': 'Kode Fitur',
                'sumber': 'Sumber Data',
                'sumber_api': 'Sumber API',
                'wilayah': 'Wilayah',
                'topik': 'Topik Data',
                'status_verifikasi': 'Status Verifikasi',
                'wakbk1': 'Kabupaten/Kota 1',
                'wakbk2': 'Kabupaten/Kota 2',
                'wapro1': 'Provinsi 1',
                'wapro2': 'Provinsi 2',
                'stsklb': 'Keterangan Batas',
                'uupp': 'Dasar Hukum (UU/PP)',
                'pjgbts': 'Panjang Batas (m)'
            };
            const lowerKey = key.toLowerCase();
            return keyMap[lowerKey] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function showFeatureInspector(properties, layerName) {
            currentInspectedProperties = properties;
            currentInspectedLayerName = layerName || 'Detail Atribut Spasial';
            
            const inspector = document.getElementById('attribute-inspector');
            const inspectorTitle = document.getElementById('inspector-layer-name');
            const inspectorBody = document.getElementById('inspector-body');
            const inspectorFooter = document.getElementById('inspector-footer');

            inspectorTitle.innerText = currentInspectedLayerName;
            
            let tableHtml = '<table class="attr-table"><tbody>';
            const hiddenKeys = ['id', 'layer_id', 'geom', 'created_at', 'updated_at', 'id_0', 'id_1', 'id_2', 'id_3'];
            let count = 0;

            for (let k in properties) {
                let val = properties[k];
                if (!hiddenKeys.includes(k.toLowerCase()) && val !== null && val !== '') {
                    let cleanKey = formatAttributeKey(k);
                    tableHtml += `<tr><th>${cleanKey}</th><td>${val}</td></tr>`;
                    count++;
                }
            }
            tableHtml += '</tbody></table>';

            if (count === 0) {
                tableHtml = '<div style="text-align:center; padding:20px; color:var(--text-muted);">Tidak ada atribut data spasial.</div>';
                if (inspectorFooter) inspectorFooter.style.display = 'none';
            } else {
                if (inspectorFooter) inspectorFooter.style.display = 'block';
            }

            inspectorBody.innerHTML = tableHtml;
            inspector.classList.add('show');
            document.body.classList.add('inspector-open');
        }

        function exportAttributeCsv() {
            if (!currentInspectedProperties) return;
            let csvContent = "data:text/csv;charset=utf-8,Atribut,Nilai\n";
            for (let k in currentInspectedProperties) {
                let val = String(currentInspectedProperties[k]).replace(/"/g, '""');
                csvContent += `"${k}","${val}"\n`;
            }
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `atribut_${(currentInspectedLayerName || 'spasial').toLowerCase().replace(/\s+/g, '_')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function printMap() {
            window.print();
        }

        function closeInspector() {
            document.getElementById('attribute-inspector').classList.remove('show');
            document.body.classList.remove('inspector-open');
        }


        // ============================================
        // 4. LAYER MANAGEMENT & API INTEGRATION
        // ============================================
        const activeLayers = {}; 
        let globalDatasets = [];
        
        function openModal() { document.getElementById('mapset-modal').classList.add('show'); }
        function closeModal() { document.getElementById('mapset-modal').classList.remove('show'); }
        function openDisasterModal() { document.getElementById('disaster-news-modal').classList.add('show'); }
        function closeDisasterModal() { document.getElementById('disaster-news-modal').classList.remove('show'); }

        async function loadDatasets() {
            try {
                const response = await fetch('/api/datasets');
                const result = await response.json();
                
                if (result.success && result.data) {
                    globalDatasets = result.data;
                    
                    const orgs = new Set();
                    globalDatasets.forEach(d => {
                        orgs.add(d.agency ? d.agency.name : 'Pemerintah Aceh');
                    });
                    const orgSelect = document.getElementById('modal-filter-org');
                    Array.from(orgs).sort().forEach(org => {
                        const opt = document.createElement('option');
                        opt.value = org;
                        opt.innerText = org;
                        orgSelect.appendChild(opt);
                    });
                    
                    document.getElementById('modal-search-input').addEventListener('input', applyModalFilters);
                    document.getElementById('modal-filter-org').addEventListener('change', applyModalFilters);
                    document.getElementById('modal-filter-sort').addEventListener('change', applyModalFilters);
                    
                    renderModalList(globalDatasets);
                    initAdminBoundariesFilter();
                    restoreLayersFromUrl();
                }
            } catch (error) {
                console.error("API Error:", error);
            } finally {
                setTimeout(() => {
                    const loader = document.getElementById('page-loader');
                    loader.style.opacity = '0';
                    setTimeout(() => loader.style.display = 'none', 400);
                }, 400);
            }
        }

        function applyModalFilters() {
            const query = document.getElementById('modal-search-input').value.toLowerCase();
            const org = document.getElementById('modal-filter-org').value;
            const sort = document.getElementById('modal-filter-sort').value;
            
            let filtered = globalDatasets.filter(d => {
                const dOrg = d.agency ? d.agency.name : 'Pemerintah Aceh';
                return (d.title.toLowerCase().includes(query) || dOrg.toLowerCase().includes(query)) && (org === "" || dOrg === org);
            });
            
            if (sort === 'asc') filtered.sort((a, b) => a.title.localeCompare(b.title));
            else if (sort === 'desc') filtered.sort((a, b) => b.title.localeCompare(a.title));
            
            renderModalList(filtered);
        }

        let kabupatenGeoJsonLayer = null;
        let kecamatanGeoJsonLayer = null;
        let desaGeoJsonLayer = null;
        let highlightedLayer = null;
        let highlightedLayerOriginalStyle = null;

        async function initAdminBoundariesFilter() {
            let kabLayerId = null;
            let kecLayerId = null;
            let desaLayerId = null;

            globalDatasets.forEach(d => {
                if (d.layers) {
                    d.layers.forEach(l => {
                        if (l.name === 'Batas Kabupaten/Kota (Riil)') kabLayerId = l.id;
                        if (l.name === 'Batas Kecamatan (Riil)') kecLayerId = l.id;
                        if (l.name === 'Batas Desa/Kelurahan (Riil)') desaLayerId = l.id;
                    });
                }
            });

            if (!kabLayerId) {
                console.warn("Batas Kabupaten/Kota tidak ditemukan. Filter wilayah dinonaktifkan.");
                return;
            }

            try {
                // 1. Fetch geojson untuk kabupaten
                const kabResponse = await fetch(`/api/layers/${kabLayerId}/geojson`);
                const kabData = await kabResponse.json();

                // 2. Fetch geojson untuk kecamatan
                let kecData = { features: [] };
                if (kecLayerId) {
                    const kecResponse = await fetch(`/api/layers/${kecLayerId}/geojson`);
                    kecData = await kecResponse.json();
                }

                // Dapatkan elemen select filter
                const filterKab = document.getElementById('filter-kabupaten');
                const filterKec = document.getElementById('filter-kecamatan');
                const filterDesa = document.getElementById('filter-desa');
                
                // Populate Kabupaten dropdown
                const uniqueKabs = [...new Set(kabData.features.map(f => f.properties.nama))].sort();
                uniqueKabs.forEach(kab => {
                    const opt = document.createElement('option');
                    opt.value = kab;
                    opt.innerText = kab;
                    filterKab.appendChild(opt);
                });

                // Add Kabupaten layer to map
                kabupatenGeoJsonLayer = L.geoJSON(kabData, {
                    style: {
                        color: '#0284c7',
                        weight: 2.5,
                        fillColor: '#0284c7',
                        fillOpacity: 0.05
                    },
                    onEachFeature: function(feature, layer) {
                        layer.bindPopup(`<div class="popup-title">Batas Kabupaten/Kota</div><div style="font-weight:700; font-size:13px;">${feature.properties.nama}</div><div style="font-size:11px; color:#6b7280; margin-top:2px;">Provinsi: ${feature.properties.provinsi}</div>`);
                        layer.on('click', function() {
                            showFeatureInspector(feature.properties, 'Batas Kabupaten/Kota');
                            filterKab.value = feature.properties.nama;
                            triggerKabupatenChange(feature.properties.nama, false);
                        });
                    }
                });

                const kabCheckbox = document.getElementById(`checkbox-layer-${kabLayerId}`);
                if (kabCheckbox && kabCheckbox.checked) {
                    kabupatenGeoJsonLayer.addTo(map);
                }

                // Add Kecamatan layer (scale dependent, so zoomend handles it)
                kecamatanGeoJsonLayer = L.geoJSON(kecData, {
                    style: {
                        color: '#10b981',
                        weight: 1.2,
                        fillColor: '#10b981',
                        fillOpacity: 0.02
                    },
                    onEachFeature: function(feature, layer) {
                        layer.bindPopup(`<div class="popup-title">Batas Kecamatan</div><div style="font-weight:700; font-size:13px;">${feature.properties.nama}</div><div style="font-size:11px; color:#6b7280; margin-top:2px;">Kabupaten: ${feature.properties.kabupaten}</div>`);
                        layer.on('click', function() {
                            showFeatureInspector(feature.properties, 'Batas Kecamatan');
                            filterKab.value = feature.properties.kabupaten;
                            triggerKabupatenChange(feature.properties.kabupaten, false);
                            filterKec.value = feature.properties.nama;
                            triggerKecamatanChange(feature.properties.nama, false);
                        });
                    }
                });

                // Check initial zoom to add/remove kecamatan layer
                const kecCheckbox = document.getElementById(`checkbox-layer-${kecLayerId}`);
                if (kecCheckbox && kecCheckbox.checked) {
                    kecamatanGeoJsonLayer.addTo(map);
                }

                map.on('zoomend', function() {
                    const zoom = map.getZoom();
                    
                    
                    // Kecamatan scale dependency
                    const kecCheckbox = document.getElementById(`checkbox-layer-${kecLayerId}`);
                    const isKecChecked = (kecCheckbox && kecCheckbox.checked);

                    if (isKecChecked) {
                        if (kecamatanGeoJsonLayer && !map.hasLayer(kecamatanGeoJsonLayer)) {
                            kecamatanGeoJsonLayer.addTo(map);
                        }
                    } else {
                        if (kecamatanGeoJsonLayer && map.hasLayer(kecamatanGeoJsonLayer)) {
                            map.removeLayer(kecamatanGeoJsonLayer);
                        }
                    }
                    
                    // Desa scale dependency for DROPDOWN logic
                    if (desaGeoJsonLayer) {
                        const desaCb = document.getElementById(`checkbox-layer-${desaLayerId}`);
                        const isDesaCbChecked = (desaCb && desaCb.checked);
                        
                        if (zoom < 12 && !isDesaCbChecked) {
                            if (map.hasLayer(desaGeoJsonLayer)) {
                                map.removeLayer(desaGeoJsonLayer);
                            }
                        } else if (filterKec.value !== "") {
                            if (!map.hasLayer(desaGeoJsonLayer)) {
                                desaGeoJsonLayer.addTo(map);
                            }
                        }
                    }
                });

                // Listen to dropdown changes
                filterKab.addEventListener('change', (e) => {
                    triggerKabupatenChange(e.target.value, true);
                });

                filterKec.addEventListener('change', (e) => {
                    triggerKecamatanChange(e.target.value, true);
                });

                filterDesa.addEventListener('change', (e) => {
                    triggerDesaChange(e.target.value, true);
                });

                function triggerKabupatenChange(kabName, shouldZoom) {
                    // Reset Kecamatan dan Desa dropdown
                    filterKec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    filterKec.disabled = true;
                    filterDesa.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                    filterDesa.disabled = true;
                    
                    if (desaGeoJsonLayer) {
                        map.removeLayer(desaGeoJsonLayer);
                        desaGeoJsonLayer = null;
                    }
                    
                    if (!kabName) {
                        highlightFeature(null);
                        if (shouldZoom) {
                            map.setView([5.5483, 95.3238], 9);
                            closeInspector();
                        }
                        return;
                    }

                    // Populate kecamatan dropdown
                    const keds = kecData.features
                        .filter(f => f.properties.kabupaten === kabName)
                        .map(f => f.properties.nama)
                        .sort();

                    keds.forEach(kec => {
                        const opt = document.createElement('option');
                        opt.value = kec;
                        opt.innerText = kec;
                        filterKec.appendChild(opt);
                    });
                    filterKec.disabled = false;

                    // Find and zoom/highlight
                    kabupatenGeoJsonLayer.eachLayer(function(layer) {
                        if (layer.feature && layer.feature.properties.nama === kabName) {
                            highlightFeature(layer, 'kabupaten');
                            if (shouldZoom) {
                                map.fitBounds(layer.getBounds(), { padding: [30, 30] });
                                setTimeout(() => layer.openPopup(), 600);
                            }
                            showFeatureInspector(layer.feature.properties, 'Batas Kabupaten/Kota');
                        }
                    });
                }

                async function triggerKecamatanChange(kecName, shouldZoom) {
                    // Reset Desa dropdown
                    filterDesa.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                    filterDesa.disabled = true;
                    
                    if (desaGeoJsonLayer) {
                        map.removeLayer(desaGeoJsonLayer);
                        desaGeoJsonLayer = null;
                    }

                    if (!kecName) {
                        // Zoom back to kabupaten bounds
                        const kabName = filterKab.value;
                        kabupatenGeoJsonLayer.eachLayer(function(layer) {
                            if (layer.feature && layer.feature.properties.nama === kabName) {
                                highlightFeature(layer, 'kabupaten');
                                if (shouldZoom) {
                                    map.fitBounds(layer.getBounds(), { padding: [30, 30] });
                                    setTimeout(() => layer.openPopup(), 600);
                                }
                                showFeatureInspector(layer.feature.properties, 'Batas Kabupaten/Kota');
                            }
                        });
                        return;
                    }

                    // Cari kode kecamatan untuk fetch desa secara spasial
                    let districtCode = null;
                    let targetKecLayer = null;
                    
                    kecamatanGeoJsonLayer.eachLayer(function(layer) {
                        if (layer.feature && layer.feature.properties.nama === kecName && layer.feature.properties.kabupaten === filterKab.value) {
                            districtCode = layer.feature.properties.district_code;
                            targetKecLayer = layer;
                        }
                    });

                    if (targetKecLayer) {
                        highlightFeature(targetKecLayer, 'kecamatan');
                        if (shouldZoom) {
                            map.fitBounds(targetKecLayer.getBounds(), { padding: [40, 40] });
                            setTimeout(() => targetKecLayer.openPopup(), 600);
                        }
                        showFeatureInspector(targetKecLayer.feature.properties, 'Batas Kecamatan');
                    }

                    if (districtCode && desaLayerId) {
                        try {
                            // Fetch GeoJSON desa untuk kecamatan terpilih secara dinamis
                            const desaRes = await fetch(`/api/layers/${desaLayerId}/geojson?district_code=${districtCode}`);
                            const desaData = await desaRes.json();

                            // Populate Desa select dropdown
                            const uniqueDesas = desaData.features.map(f => f.properties.nama).sort();
                            uniqueDesas.forEach(desa => {
                                const opt = document.createElement('option');
                                opt.value = desa;
                                opt.innerText = desa;
                                filterDesa.appendChild(opt);
                            });
                            filterDesa.disabled = false;

                            // Render layer desa di peta
                            desaGeoJsonLayer = L.geoJSON(desaData, {
                                style: {
                                    color: '#4b5563',
                                    weight: 1.0,
                                    fillColor: '#4b5563',
                                    fillOpacity: 0.03
                                },
                                onEachFeature: function(feature, layer) {
                                    layer.bindPopup(`<div class="popup-title">Batas Desa/Kelurahan</div><div style="font-weight:700; font-size:13px;">${feature.properties.nama}</div><div style="font-size:11px; color:#6b7280; margin-top:2px;">Kecamatan: ${feature.properties.district}</div><div style="font-size:11px; color:#6b7280;">Kabupaten: ${feature.properties.regency}</div>`);
                                    layer.on('click', function() {
                                        showFeatureInspector(feature.properties, 'Batas Desa/Kelurahan');
                                        filterDesa.value = feature.properties.nama;
                                        triggerDesaChange(feature.properties.nama, false);
                                    });
                                }
                            });

                            // Hanya gambar desa di peta jika zoom level mencukupi
                            const desaCb = document.getElementById(`checkbox-layer-${desaLayerId}`);
                            const isDesaCbChecked = (!desaCb || desaCb.checked);
                            if ((map.getZoom() >= 12 || shouldZoom) && isDesaCbChecked) {
                                desaGeoJsonLayer.addTo(map);
                            }
                        } catch (err) {
                            console.error("Gagal memuat batas desa:", err);
                        }
                    }
                }

                function triggerDesaChange(desaName, shouldZoom) {
                    if (!desaName) {
                        // Zoom back to kecamatan bounds
                        const kecName = filterKec.value;
                        kecamatanGeoJsonLayer.eachLayer(function(layer) {
                            if (layer.feature && layer.feature.properties.nama === kecName && layer.feature.properties.kabupaten === filterKab.value) {
                                highlightFeature(layer, 'kecamatan');
                                if (shouldZoom) {
                                    map.fitBounds(layer.getBounds(), { padding: [40, 40] });
                                    setTimeout(() => layer.openPopup(), 600);
                                }
                                showFeatureInspector(layer.feature.properties, 'Batas Kecamatan');
                            }
                        });
                        return;
                    }

                    // Find and zoom/highlight desa
                    if (desaGeoJsonLayer) {
                        desaGeoJsonLayer.eachLayer(function(layer) {
                            if (layer.feature && layer.feature.properties.nama === desaName) {
                                // Pastikan layer desa ada di peta
                                if (!map.hasLayer(desaGeoJsonLayer)) {
                                    desaGeoJsonLayer.addTo(map);
                                }
                                highlightFeature(layer, 'desa');
                                if (shouldZoom) {
                                    map.fitBounds(layer.getBounds(), { padding: [40, 40] });
                                    setTimeout(() => layer.openPopup(), 600);
                                }
                                showFeatureInspector(layer.feature.properties, 'Batas Desa/Kelurahan');
                            }
                        });
                    }
                }

                function highlightFeature(layer, type) {
                    if (highlightedLayer) {
                        highlightedLayer.setStyle(highlightedLayerOriginalStyle);
                    }
                    if (layer) {
                        highlightedLayer = layer;
                        highlightedLayerOriginalStyle = {
                            color: type === 'kabupaten' ? '#0284c7' : (type === 'kecamatan' ? '#10b981' : '#4b5563'),
                            weight: type === 'kabupaten' ? 2.5 : (type === 'kecamatan' ? 1.2 : 1.0),
                            fillOpacity: type === 'kabupaten' ? 0.05 : (type === 'kecamatan' ? 0.02 : 0.03)
                        };
                        layer.setStyle({
                            color: '#dc2626',
                            weight: 3.5,
                            fillOpacity: 0.12
                        });
                    } else {
                        highlightedLayer = null;
                        highlightedLayerOriginalStyle = null;
                    }
                }

                // Sinkronisasikan katalog dan list layer aktif secara otomatis untuk batas wilayah riil
                globalDatasets.forEach(d => {
                    if (d.slug === 'batas-kabupaten-kota-aceh-riil' || 
                        d.slug === 'batas-kecamatan-aceh-riil' || 
                        d.slug === 'batas-desa-kelurahan-aceh-riil') {
                        selectedDatasets[d.id] = d;
                        addDatasetToSidebar(d);
                    }
                });
                updateSidebarWidgetTitle();

            } catch (err) {
                console.error("Gagal menginisialisasi filter batas wilayah: ", err);
            }
        }

        let selectedDatasets = {};

        function renderModalList(datasets) {
            const container = document.getElementById('modal-mapset-list');
            container.innerHTML = ''; 
            
            if (datasets.length === 0) {
                container.innerHTML = '<div style="text-align:center;color:var(--text-muted);padding:20px;">Belum ada dataset.</div>';
                return;
            }

            datasets.forEach(dataset => {
                const item = document.createElement('div');
                item.className = 'mapset-item';
                if(selectedDatasets[dataset.id]) item.classList.add('selected');
                
                item.onclick = () => {
                    showDatasetPreview(dataset);
                    document.querySelectorAll('.mapset-item').forEach(el => el.style.borderLeft = 'none');
                    item.style.borderLeft = '4px solid var(--primary)';
                    
                    // Toggle selection
                    cb.checked = !cb.checked;
                    toggleMapset(cb.checked, dataset, item);
                };
                
                const orgName = dataset.agency ? dataset.agency.name : 'Pemerintah Aceh';
                let iconSymbol = '🗺️';
                const catName = strtolower(dataset.category ? dataset.category.name : '');
                if (catName.includes('lingkungan')) iconSymbol = '🌿';
                else if (catName.includes('pendidikan')) iconSymbol = '🎓';
                else if (catName.includes('bencana')) iconSymbol = '🌊';
                else if (catName.includes('kesehatan')) iconSymbol = '🏥';

                item.innerHTML = `
                    <div class="mapset-item-icon">${iconSymbol}</div>
                    <div class="mapset-item-info">
                        <div class="mapset-item-title">${dataset.title}</div>
                        <div class="mapset-item-org">${orgName}</div>
                    </div>
                `;
                
                const cb = document.createElement('input');
                cb.type = 'checkbox';
                if (selectedDatasets[dataset.id]) cb.checked = true;
                cb.style.cssText = 'width:18px;height:18px;accent-color:var(--primary);cursor:pointer;';
                cb.onclick = (e) => {
                    e.stopPropagation();
                    toggleMapset(cb.checked, dataset, item);
                };
                item.appendChild(cb);
                container.appendChild(item);
            });
        }

        function strtolower(str) { return (str || '').toLowerCase(); }

        async function toggleMapset(isChecked, dataset, itemElement) {
            if (isChecked) {
                itemElement.classList.add('selected');
                selectedDatasets[dataset.id] = dataset;
                addDatasetToSidebar(dataset);
            } else {
                itemElement.classList.remove('selected');
                delete selectedDatasets[dataset.id];
                removeDatasetFromSidebar(dataset);
            }
            updateSidebarWidgetTitle();
            showDatasetPreview(dataset);
        }
        
        function showDatasetPreview(dataset) {
            const previewContainer = document.getElementById('modal-preview-content');
            if (!dataset) return;
            
            const orgName = dataset.agency ? dataset.agency.name : 'Pemerintah Aceh';
            let layersHtml = '';
            if (dataset.layers && dataset.layers.length > 0) {
                layersHtml = '<ul style="margin-top:10px; padding-left:20px; font-size:13px; color:var(--text-muted); line-height:1.6;">';
                dataset.layers.forEach(l => { layersHtml += `<li><strong>${l.name}</strong> (${l.geometry_type})</li>`; });
                layersHtml += '</ul>';
            } else {
                layersHtml = '<div style="margin-top:10px; font-size:13px; color:#dc2626;">Dataset belum memiliki layer spasial.</div>';
            }
            
            previewContainer.innerHTML = `
                <div style="background:white; border-radius:12px; padding:28px; width:100%; max-width:520px; box-shadow:var(--shadow-lg);">
                    <div style="font-size:12px; font-weight:700; color:var(--primary); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">${dataset.category ? dataset.category.name : 'Sektor Spasial'}</div>
                    <h2 style="font-size:20px; font-weight:800; color:var(--text-dark); margin-bottom:6px;">${dataset.title}</h2>
                    <div style="font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:16px;">🏢 ${orgName}</div>
                    <p style="font-size:13px; color:var(--text-dark); line-height:1.5; margin-bottom:20px;">${dataset.description}</p>
                    <div style="font-size:13px; border-top:1px solid var(--border); padding-top:16px;">
                        <div style="font-weight:700; font-size:12px; color:var(--text-muted); text-transform:uppercase;">Daftar Layer (${dataset.layers ? dataset.layers.length : 0})</div>
                        ${layersHtml}
                    </div>
                </div>
            `;
        }
        
        function addDatasetToSidebar(dataset) {
            const listContainer = document.getElementById('sidebar-layer-list');
            const itemsContainer = document.getElementById('layer-items-container');
            
            if(dataset.layers && dataset.layers.length > 0) {
                listContainer.style.display = 'block';

                dataset.layers.forEach(layer => {
                    if (document.getElementById(`sidebar-layer-item-${layer.id}`)) return;

                    const div = document.createElement('div');
                    div.className = 'layer-item';
                    div.id = `sidebar-layer-item-${layer.id}`;
                    div.setAttribute('data-dataset-id', dataset.id);
                    div.setAttribute('data-layer-id', layer.id);
                    div.style.flexDirection = 'column';
                    div.style.alignItems = 'stretch';
                    div.style.background = 'white';
                    div.style.padding = '10px 12px';
                    div.style.borderRadius = 'var(--radius-md)';
                    div.style.border = '1px solid var(--border)';
                    div.style.marginBottom = '8px';
                    div.style.boxShadow = '0 1px 3px rgba(0,0,0,0.02)';
                    div.style.transition = 'border-color 0.2s';
                    div.onmouseenter = () => div.style.borderColor = 'var(--primary)';
                    div.onmouseleave = () => div.style.borderColor = 'var(--border)';

                    div.innerHTML = `
                        <div style="display:flex; align-items:center;">
                            <label class="checkbox-container">
                                <input type="checkbox" id="checkbox-layer-${layer.id}" checked aria-label="Tampilkan layer ${layer.name}" onchange="toggleSidebarLayer(this, ${layer.id}, '${layer.name.replace(/'/g, "\\'")}')">
                                <div class="checkmark"></div>
                                <span class="layer-name" style="font-weight:700; font-size:12px;">${layer.name}</span>
                            </label>
                            <div id="layer-status-${layer.id}" style="margin-left:auto; display:flex; align-items:center; font-size:11px; height:18px;"></div>
                        </div>
                        <div style="font-size:10px; color:var(--text-muted); margin-left:26px; margin-top:2px;">${dataset.title}</div>
                        <div class="layer-controls" id="layer-controls-${layer.id}" style="display:flex; padding-left: 26px; margin-top: 8px; gap: 8px; font-size: 10px; align-items:center;">
                            <span style="color:var(--text-muted);">Opasitas:</span>
                            <input type="range" min="0" max="100" value="100" aria-label="Opasitas layer ${layer.name}" style="width:60px; height:4px; cursor:pointer; accent-color:var(--primary);" onchange="changeLayerOpacity(${layer.id}, this.value)" oninput="changeLayerOpacity(${layer.id}, this.value)">
                            <div style="display:flex; gap:4px; margin-left:auto;">
                                <button onclick="moveLayerUp(${layer.id})" title="Naikkan Layer" aria-label="Naikkan urutan layer ${layer.name}" style="background:white; color:var(--text-dark); border:1px solid var(--border); border-radius:4px; cursor:pointer; font-size:10px; padding:6px 10px; transition:all 0.2s;" onmouseover="this.style.background='var(--primary-light)';this.style.color='var(--primary)';this.style.borderColor='var(--primary)';" onmouseout="this.style.background='white';this.style.color='var(--text-dark)';this.style.borderColor='var(--border)';">▲</button>
                                <button onclick="moveLayerDown(${layer.id})" title="Turunkan Layer" aria-label="Turunkan urutan layer ${layer.name}" style="background:white; color:var(--text-dark); border:1px solid var(--border); border-radius:4px; cursor:pointer; font-size:10px; padding:6px 10px; transition:all 0.2s;" onmouseover="this.style.background='var(--primary-light)';this.style.color='var(--primary)';this.style.borderColor='var(--primary)';" onmouseout="this.style.background='white';this.style.color='var(--text-dark)';this.style.borderColor='var(--border)';">▼</button>
                            </div>
                        </div>
                    `;
                    itemsContainer.appendChild(div);
                    loadLayerToMap(layer.id, layer.name);
                });
            }
        }

        function removeDatasetFromSidebar(dataset) {
            const items = document.querySelectorAll(`.layer-item[data-dataset-id="${dataset.id}"]`);
            items.forEach(item => {
                const layerId = parseInt(item.getAttribute('data-layer-id'));
                item.remove();
                if (activeLayers[layerId]) {
                    map.removeLayer(activeLayers[layerId]);
                    delete activeLayers[layerId];
                }
                const idx = globalLayerOrder.indexOf(layerId);
                if (idx > -1) globalLayerOrder.splice(idx, 1);
            });
            
            if(dataset.layers && dataset.layers.length > 0) {
                dataset.layers.forEach(layer => {
                    if (layer.name.includes('(Riil)')) {
                        if (layer.name.includes('Kabupaten/Kota') && kabupatenGeoJsonLayer) {
                            map.removeLayer(kabupatenGeoJsonLayer);
                        } else if (layer.name.includes('Kecamatan') && kecamatanGeoJsonLayer) {
                            map.removeLayer(kecamatanGeoJsonLayer);
                        } else if (layer.name.includes('Desa/Kelurahan') && desaGeoJsonLayer) {
                            map.removeLayer(desaGeoJsonLayer);
                        }
                    }
                });
            }
            if (document.getElementById('layer-items-container').children.length === 0) {
                document.getElementById('sidebar-layer-list').style.display = 'none';
            }
            updateLegend();
        }

        function updateSidebarWidgetTitle() {
            const keys = Object.keys(selectedDatasets);
            const titleEl = document.getElementById('active-mapset-title');
            const descEl = document.getElementById('active-mapset-desc');
            
            if (keys.length === 0) {
                titleEl.innerText = 'Pilih Mapset Spasial';
                titleEl.style.color = 'var(--text-dark)';
                descEl.innerText = 'Klik tombol di bawah untuk memilih layer data geospasial Provinsi Aceh.';
            } else if (keys.length === 1) {
                const ds = selectedDatasets[keys[0]];
                titleEl.innerText = ds.title;
                titleEl.style.color = 'var(--primary)';
                descEl.innerText = ds.agency ? ds.agency.name : 'Terpilih';
            } else {
                titleEl.innerText = `${keys.length} Dataset Terpilih`;
                titleEl.style.color = 'var(--primary)';
                descEl.innerText = 'Beberapa layer aktif di atas peta';
            }
        }
        
        async function toggleSidebarLayer(checkbox, layerId, layerName) {
            if (layerName.includes('(Riil)')) {
                if (layerName.includes('Kabupaten/Kota')) {
                    if (checkbox.checked) {
                        if (kabupatenGeoJsonLayer) kabupatenGeoJsonLayer.addTo(map);
                    } else {
                        if (kabupatenGeoJsonLayer) map.removeLayer(kabupatenGeoJsonLayer);
                    }
                    return;
                } else if (layerName.includes('Kecamatan')) {
                    if (checkbox.checked) {
                        if (kecamatanGeoJsonLayer) kecamatanGeoJsonLayer.addTo(map);
                    } else {
                        if (kecamatanGeoJsonLayer) map.removeLayer(kecamatanGeoJsonLayer);
                    }
                    return;
                }
                // Jika layerName.includes('Desa/Kelurahan'), fallthrough ke logika fetchLayerData biasa
            }

            const controlsDiv = document.getElementById(`layer-controls-${layerId}`);
            if (controlsDiv) {
                controlsDiv.style.display = checkbox.checked ? 'flex' : 'none';
            }

            if (checkbox.checked) {
                if (!globalLayerOrder.includes(layerId)) {
                    globalLayerOrder.unshift(layerId);
                    reorderSidebarElements();
                }
                if (activeLayers[layerId]) {
                    activeLayers[layerId].addTo(map);
                    applyLayerOrder();
                    updateLegend();
                }
                else await loadLayerToMap(layerId, layerName);
            } else {
                if (activeLayers[layerId]) map.removeLayer(activeLayers[layerId]);
                updateLegend();
            }
        }

        const layerState = {};
        const shownTruncationWarnings = new Set();
        const globalLayerOrder = [];

        function getLayerStyleConfig(layerName) {
            const ln = layerName.toLowerCase();
            if (ln.includes('sekolah') || ln.includes('pendidikan')) return { color: "#4f46e5", fillColor: "#4f46e5", isPoint: true };
            else if (ln.includes('kesehatan') || ln.includes('rumah sakit')) return { color: "#0d9488", fillColor: "#0d9488", isPoint: true };
            else if (ln.includes('bencana') || ln.includes('banjir') || ln.includes('tsunami')) return { color: "#dc2626", fillColor: "#ef4444", isPoint: false };
            else if (ln.includes('hutan') || ln.includes('konservasi')) return { color: "#059669", fillColor: "#10b981", isPoint: false };
            return { color: "#198754", fillColor: "#2eb87d", isPoint: false };
        }

        function changeLayerOpacity(layerId, value) {
            if (!layerState[layerId]) layerState[layerId] = { opacity: 100 };
            layerState[layerId].opacity = parseInt(value);
            applyLayerOpacity(layerId);
        }

        function applyLayerOpacity(layerId) {
            if (!activeLayers[layerId]) return;
            const op = (layerState[layerId].opacity !== undefined ? layerState[layerId].opacity : 100) / 100;
            
            activeLayers[layerId].eachLayer(function(layer) {
                if (layer.setStyle) {
                    if (layer instanceof L.CircleMarker) {
                        layer.setStyle({ opacity: op, fillOpacity: op * 0.85 });
                    } else if (layer instanceof L.Polyline && !(layer instanceof L.Polygon)) {
                        layer.setStyle({ opacity: op });
                    } else {
                        layer.setStyle({ opacity: op, fillOpacity: op * 0.4 });
                    }
                }
            });
        }

        function moveLayerUp(layerId) {
            const idx = globalLayerOrder.indexOf(layerId);
            if (idx > 0) { // Move towards 0 (Top)
                [globalLayerOrder[idx - 1], globalLayerOrder[idx]] = [globalLayerOrder[idx], globalLayerOrder[idx - 1]];
                applyLayerOrder();
                reorderSidebarElements();
                updateLegend();
            }
        }

        function moveLayerDown(layerId) {
            const idx = globalLayerOrder.indexOf(layerId);
            if (idx !== -1 && idx < globalLayerOrder.length - 1) { // Move towards bottom
                [globalLayerOrder[idx + 1], globalLayerOrder[idx]] = [globalLayerOrder[idx], globalLayerOrder[idx + 1]];
                applyLayerOrder();
                reorderSidebarElements();
                updateLegend();
            }
        }

        function applyLayerOrder() {
            // Re-apply z-index for all vector layers by bringing them to front from bottom to top
            for (let i = globalLayerOrder.length - 1; i >= 0; i--) {
                const id = globalLayerOrder[i];
                if (activeLayers[id] && map.hasLayer(activeLayers[id])) {
                    activeLayers[id].bringToFront();
                }
            }
        }

        function reorderSidebarElements() {
            const container = document.getElementById('layer-items-container');
            // Index 0 is TOP, so insert at top of container iteratively backwards
            for (let i = globalLayerOrder.length - 1; i >= 0; i--) {
                const id = globalLayerOrder[i];
                const item = document.getElementById(`sidebar-layer-item-${id}`);
                if (item) {
                    container.insertBefore(item, container.firstChild);
                }
            }
        }

        function updateLegend() {
            const legend = document.getElementById('legend-widget');
            const container = document.getElementById('legend-items');
            container.innerHTML = '';
            
            let hasActive = false;
            for (let i = 0; i < globalLayerOrder.length; i++) {
                const id = globalLayerOrder[i];
                const checkbox = document.getElementById(`checkbox-layer-${id}`);
                if (checkbox && checkbox.checked && layerState[id]) {
                    hasActive = true;
                    const layerName = layerState[id].name || 'Layer';
                    const style = getLayerStyleConfig(layerName);
                    
                    let symbolHtml = '';
                    if (style.isPoint) {
                        symbolHtml = `<div style="width:14px; height:14px; border-radius:50%; background:${style.fillColor}; border:2px solid #fff; box-shadow:0 0 4px rgba(0,0,0,0.3);"></div>`;
                    } else {
                        symbolHtml = `<div style="width:16px; height:16px; background:${style.fillColor}; opacity:0.7; border:2px solid ${style.color}; border-radius:3px;"></div>`;
                    }
                    
                    container.innerHTML += `
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px; font-size:12px; font-weight:600; color:var(--text-dark);">
                            ${symbolHtml}
                            <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:180px;" title="${layerName}">${layerName}</div>
                        </div>
                    `;
                }
            }
            
            if (hasActive) {
                legend.style.display = 'block';
            } else {
                legend.style.display = 'none';
            }
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function showToast(message, type = 'warning') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'toast-msg';
            toast.setAttribute('role', type === 'error' || type === 'warning' ? 'alert' : 'status');
            toast.setAttribute('aria-live', 'assertive');
            const bg = type === 'warning' ? '#f59e0b' : (type === 'error' ? '#dc2626' : '#198754');
            toast.style.background = bg;
            toast.innerHTML = `<span>⚠️</span> ${message}`;
            container.appendChild(toast);
            setTimeout(() => toast.style.opacity = '1', 10);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 4500);
        }

        async function fetchLayerData(layerId, layerName, isInitialLoad = false) {
            if (!layerState[layerId]) {
                layerState[layerId] = { controller: null, version: 0, opacity: 100, name: layerName };
            }
            const state = layerState[layerId];
            
            if (!globalLayerOrder.includes(layerId)) {
                globalLayerOrder.unshift(layerId);
                reorderSidebarElements();
                updateUrlLayers();
            }
            
            // Abort previous request to prevent race condition
            if (state.controller) {
                state.controller.abort();
            }
            
            state.controller = new AbortController();
            state.version++;
            const currentVersion = state.version;
            
            const bbox = map.getBounds().toBBoxString();
            
            const statusEl = document.getElementById(`layer-status-${layerId}`);
            if (statusEl) statusEl.innerHTML = `<div class="layer-spinner"></div>`;
            
            try {
                const response = await fetch(`/api/layers/${layerId}/geojson?bbox=${bbox}`, {
                    signal: state.controller.signal
                });
                
                if (currentVersion !== state.version) return;
                
                if (!response.ok) {
                    let errorMsg = "Gagal memuat.";
                    if (response.status === 403) errorMsg = "Akses ditolak.";
                    else if (response.status === 422) errorMsg = "BBOX tidak valid.";
                    else if (response.status === 429) errorMsg = "Limit request.";
                    if (statusEl) statusEl.innerHTML = `<span style="color:#dc2626; font-weight:700;" title="${errorMsg}">❌ Error</span>`;
                    return;
                }
                
                const geojsonData = await response.json();
                if (currentVersion !== state.version) return;
                
                if (!geojsonData.features || geojsonData.features.length === 0) {
                    if (statusEl) statusEl.innerHTML = `<span style="color:#6b7280; font-style:italic;" title="Tidak ada data pada area peta ini">Area Kosong</span>`;
                } else {
                    if (statusEl) statusEl.innerHTML = ``;
                }
                
                if (geojsonData.truncated) {
                    const warningKey = `${layerId}-${bbox}`;
                    if (!shownTruncationWarnings.has(warningKey)) {
                        showToast(`Data "${layerName}" terlalu banyak di area ini. Silakan perbesar peta.`);
                        shownTruncationWarnings.add(warningKey);
                    }
                }
                
                if (!activeLayers[layerId]) {
                    const geoJsonLayer = L.geoJSON(geojsonData, {
                        pointToLayer: function (feature, latlng) {
                            let style = getLayerStyleConfig(layerName);
                            let op = (layerState[layerId].opacity !== undefined ? layerState[layerId].opacity : 100) / 100;
                            return L.circleMarker(latlng, { radius: 7, fillColor: style.fillColor, color: "#ffffff", weight: 2, opacity: op, fillOpacity: op * 0.85 });
                        },
                        style: function (feature) {
                            let style = getLayerStyleConfig(layerName);
                            let op = (layerState[layerId].opacity !== undefined ? layerState[layerId].opacity : 100) / 100;
                            return { color: style.color, weight: 2, fillColor: style.fillColor, opacity: op, fillOpacity: op * 0.4 };
                        },
                        onEachFeature: function (feature, layer) {
                            layer.on('click', function(e) { if (feature.properties) showFeatureInspector(feature.properties, layerName); });
                            let popupHtml = `<div class="popup-title">${layerName}</div><div class="popup-subtitle">PROVINSI ACEH</div>`;
                            if (feature.properties) {
                                const hiddenKeys = ['id', 'layer_id', 'geom', 'created_at', 'updated_at'];
                                for (let key in feature.properties) {
                                    let val = feature.properties[key];
                                    if (!hiddenKeys.includes(key.toLowerCase()) && val !== null && val !== '') {
                                        popupHtml += `<div class="popup-prop"><span>${formatAttributeKey(key)}</span><strong>${val}</strong></div>`;
                                    }
                                }
                            }
                            layer.bindPopup(popupHtml, { minWidth: 220 });
                        }
                    });
                    
                    activeLayers[layerId] = geoJsonLayer;
                    
                    const checkbox = document.getElementById(`checkbox-layer-${layerId}`);
                    if (!checkbox || checkbox.checked) {
                        geoJsonLayer.addTo(map);
                        if (isInitialLoad && geojsonData.features.length > 0) {
                            try { map.fitBounds(geoJsonLayer.getBounds(), { padding: [30, 30] }); } catch(err) {}
                        }
                    }
                } else {
                    const geoJsonLayer = activeLayers[layerId];
                    geoJsonLayer.clearLayers();
                    if (geojsonData.features && geojsonData.features.length > 0) {
                        geoJsonLayer.addData(geojsonData);
                    }
                }

                // Re-apply opacity, ordering, and legend after fetching data
                applyLayerOpacity(layerId);
                applyLayerOrder();
                updateLegend();
            } catch(e) {
                if (currentVersion !== state.version) return;
                if (e.name === 'AbortError') return;
                console.error("Error loading layer", e);
                if (statusEl) statusEl.innerHTML = `<span style="color:#dc2626;" title="Error koneksi">⚠️</span>`;
            } finally {
                if (currentVersion === state.version) {
                    state.controller = null;
                }
            }
        }

        async function loadLayerToMap(layerId, layerName) {
            if (layerName.includes('(Riil)')) {
                if (layerName.includes('Kabupaten/Kota')) {
                    if (kabupatenGeoJsonLayer) kabupatenGeoJsonLayer.addTo(map);
                    return;
                } else if (layerName.includes('Kecamatan')) {
                    if (kecamatanGeoJsonLayer) kecamatanGeoJsonLayer.addTo(map);
                    return;
                }
                // Desa/Kelurahan diteruskan ke fetchLayerData
            }
            fetchLayerData(layerId, layerName, true);
        }

        const debouncedViewportUpdate = debounce(() => {
            const center = map.getCenter();
            const zoom = map.getZoom();
            const url = new URL(window.location);
            url.searchParams.set('lat', center.lat.toFixed(5));
            url.searchParams.set('lng', center.lng.toFixed(5));
            url.searchParams.set('z', zoom);
            window.history.replaceState({}, '', url);

            for (let layerId in activeLayers) {
                const checkbox = document.getElementById(`checkbox-layer-${layerId}`);
                if (checkbox && checkbox.checked) {
                    const label = checkbox.closest('.layer-item')?.querySelector('.layer-name');
                    const layerName = label ? label.innerText : 'Layer';
                    fetchLayerData(layerId, layerName, false);
                }
            }
        }, 700);

        map.on('moveend', debouncedViewportUpdate);
        map.on('zoomend', debouncedViewportUpdate);

        function updateUrlLayers() {
            const url = new URL(window.location);
            if (globalLayerOrder.length > 0) {
                url.searchParams.set('layers', globalLayerOrder.join(','));
            } else {
                url.searchParams.delete('layers');
            }
            window.history.replaceState({}, '', url);
        }

        function restoreLayersFromUrl() {
            const params = new URLSearchParams(window.location.search);
            const layersStr = params.get('layers');
            if (!layersStr) return;

            const layerIds = [...new Set(layersStr.split(',').map(id => parseInt(id)).filter(id => !isNaN(id)))];
            if (layerIds.length === 0) return;

            layerIds.forEach(id => globalLayerOrder.push(id));
            
            window._isRestoringUrl = true;
            window._urlLayerIds = layerIds;

            layerIds.forEach(id => {
                for (let i = 0; i < globalDatasets.length; i++) {
                    const ds = globalDatasets[i];
                    if (ds.layers && ds.layers.some(l => l.id === id)) {
                        addDatasetToSidebar(ds);
                        break;
                    }
                }
            });
            
            window._isRestoringUrl = false;
            updateUrlLayers();
        }

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', async () => {
            const loadPromise = loadDatasets();
            if (loadPromise instanceof Promise) {
                await loadPromise;
            }
            
            // Thematic Map Autoload Layer Configuration
            if (tematikConfig && tematikConfig.layers) {
                setTimeout(() => {
                    tematikConfig.layers.forEach(l => {
                        if (l.tipe === 'wms') {
                            // Add external WMS Layer to map
                            const wmsLayer = L.tileLayer.wms(l.url, {
                                layers: l.layers,
                                format: l.format || 'image/png',
                                transparent: l.transparent !== false,
                                opacity: (l.opacity !== undefined ? l.opacity : 1.0)
                            }).addTo(map);
                            
                            // Manually append to legend
                            const legendContainer = document.getElementById('legend-items');
                            const legendWidget = document.getElementById('legend-widget');
                            if (legendContainer && legendWidget) {
                                legendContainer.innerHTML += `
                                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px; font-size:12px; font-weight:600; color:var(--text-dark);">
                                        <div style="width:16px; height:16px; background:#e5e7eb; border:2px solid #9ca3af; border-radius:3px; display:flex; align-items:center; justify-content:center; font-size:8px; color: #4b5563;">API</div>
                                        <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:180px;" title="${l.name}">${l.name}</div>
                                    </div>
                                `;
                                legendWidget.style.display = 'block';
                            }
                        } else if (l.dataset_slug) {
                            // Local uploaded dataset
                            const ds = globalDatasets.find(d => d.slug === l.dataset_slug);
                            if (ds) {
                                addDatasetToSidebar(ds);
                                if (l.color || l.opacity) {
                                    ds.layers.forEach(layerItem => {
                                        if (l.opacity !== undefined) {
                                            setTimeout(() => changeLayerOpacity(layerItem.id, l.opacity * 100), 500);
                                        }
                                    });
                                }
                            }
                        }
                    });
                }, 500);
            }

            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('q');
            if (query) {
                searchInput.value = query;
                setTimeout(() => { performSearch(); }, 800);
            }
        });

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggleBtn = document.getElementById('mobile-sidebar-toggle');
            const isOpen = sidebar.classList.contains('open');
            
            if (isOpen) {
                sidebar.classList.remove('open');
                backdrop.classList.remove('show');
                toggleBtn.setAttribute('aria-expanded', 'false');
            } else {
                sidebar.classList.add('open');
                backdrop.classList.add('show');
                toggleBtn.setAttribute('aria-expanded', 'true');
            }
            
            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        }
    </script>
</body>
</html>
```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/views/welcome.blade.php

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaKita Aceh — Platform Geoportal Aceh</title>
    <meta name="description" content="Portal data geospasial terpadu Provinsi Aceh. Jelajahi, analisis, dan unduh ribuan dataset peta terbuka.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet & Measure CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-measure/dist/leaflet-measure.css" />
    <style>
        /* ============================================
           DESIGN TOKENS
           ============================================ */
        :root {
            --bg-base: #f4f6fb;
            --bg-surface: #eef1f7;
            --bg-card: #ffffff;
            --bg-card-hover: #f8faff;
            --accent: #1a7f4f;
            --accent-dim: #155f3a;
            --accent-muted: rgba(26,127,79,0.1);
            --accent-glow: rgba(26,127,79,0.2);
            --accent-light: #e6f5ed;
            --white: #ffffff;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --text-muted: #9ca3af;
            --border: rgba(0,0,0,0.08);
            --border-hover: rgba(26,127,79,0.35);
            --glass-bg: rgba(255,255,255,0.8);
            --glass-border: rgba(26,127,79,0.15);
            --font-main: 'Inter', sans-serif;
            --font-display: 'Space Grotesk', sans-serif;
        }

        /* ============================================
           RESET & BASE
           ============================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; overflow-x: hidden; }

        body {
            font-family: var(--font-main);
            background: var(--bg-base);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            cursor: none;
        }

        /* ============================================
           CUSTOM CURSOR
           ============================================ */
        .cursor-dot {
            position: fixed;
            top: 0; left: 0;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: width 0.2s, height 0.2s, background 0.2s;
            mix-blend-mode: multiply;
        }

        .cursor-halo {
            position: fixed;
            top: 0; left: 0;
            width: 40px; height: 40px;
            border: 1.5px solid var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: width 0.4s cubic-bezier(.25,.46,.45,.94),
                        height 0.4s cubic-bezier(.25,.46,.45,.94),
                        border-color 0.3s,
                        left 0.1s cubic-bezier(.25,.46,.45,.94),
                        top 0.1s cubic-bezier(.25,.46,.45,.94);
            box-shadow: 0 0 15px var(--accent-glow);
        }

        body.hovering .cursor-halo {
            width: 72px; height: 72px;
            border-color: var(--accent);
            box-shadow: 0 0 30px var(--accent-glow), inset 0 0 20px var(--accent-muted);
        }
        body.hovering .cursor-dot {
            width: 4px; height: 4px;
            opacity: 0.6;
        }

        /* ============================================
           SCROLLBAR
           ============================================ */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: #c1d1be; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        /* ============================================
           PARTICLES CANVAS
           ============================================ */
        #particles-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.15;
        }

        /* ============================================
           NAVIGATION
           ============================================ */
        nav {
            position: fixed;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 48px);
            max-width: 1400px;
            z-index: 1000;
            margin-top: 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.3s;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent), #6eff99);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .nav-logo-text {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
            line-height: 1.1;
        }

        .nav-logo-text span { color: var(--accent); }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 4px;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }

        .nav-links a:hover {
            color: var(--text-primary);
            background: var(--accent-muted);
        }

        .nav-cta {
            background: var(--accent);
            color: var(--bg-base) !important;
            font-weight: 700 !important;
            padding: 9px 20px !important;
            border-radius: 10px !important;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s !important;
        }

        .nav-cta:hover {
            background: white !important;
            box-shadow: 0 0 25px var(--accent-glow) !important;
            transform: scale(1.03) !important;
        }

        /* ============================================
           HERO SECTION
           ============================================ */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background-image: url("/assets/images/mosque_sunset_bg.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.25) 50%, rgba(0, 0, 0, 0.55) 100%);
            z-index: 1;
        }

        .hero-container {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 100%;
            max-width: 900px;
            padding: 0 24px;
            margin-top: -50px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(48px, 6vw, 76px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 24px;
            text-shadow: 0 2px 15px rgba(0,0,0,0.4);
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 48px;
            text-shadow: 0 1px 8px rgba(0,0,0,0.5);
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .hero-search-box {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 100px;
            padding: 10px 10px 10px 28px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-search-box input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 18px;
            font-family: var(--font-main);
            color: var(--text-primary);
            background: transparent;
        }

        .hero-search-box input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        .hero-search-btn {
            background: var(--accent);
            color: #ffffff;
            border: none;
            padding: 16px 36px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 16px;
            cursor: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s, transform 0.2s;
            text-decoration: none;
        }

        .hero-search-btn:hover {
            background: var(--accent-dim);
            transform: scale(1.03);
        }

        /* Nav adjustment for readability over image */
        nav {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        /* ============================================
           SECTION COMMON
           ============================================ */
        section {
            position: relative;
            z-index: 1;
        }

        .section-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .section-label {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 14px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        .section-subtitle {
            font-size: 17px;
            color: var(--text-secondary);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ============================================
           INTERACTIVE MAP SECTION
           ============================================ */
        .interactive-map-section {
            padding: 80px 24px;
            background: var(--bg-surface);
            position: relative;
        }

        .map-preview-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            height: 600px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: #e8edf0;
            cursor: default !important; /* override custom cursor */
        }
        .map-preview-container * {
            cursor: auto !important; /* restore normal cursor inside map */
        }

        #homeMap {
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* Leaflet Overrides */
        .leaflet-control-zoom a { background: var(--bg-card) !important; color: var(--text-primary) !important; border-color: var(--border) !important; box-shadow: 0 1px 5px rgba(0,0,0,0.15); }
        .leaflet-control-zoom a:hover { color: var(--accent) !important; background: var(--accent-light) !important; }
        .leaflet-popup-content-wrapper { background: var(--glass-bg); backdrop-filter: blur(15px); border: 1px solid var(--glass-border); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .leaflet-popup-tip { background: white; }
        .popup-title { font-family: var(--font-display); font-size: 14px; font-weight: 700; border-bottom: 2px solid var(--accent); margin-bottom: 8px; padding-bottom: 4px; }
        .popup-prop { font-size: 12px; margin-bottom: 6px; display: grid; grid-template-columns: minmax(80px, 1fr) 2fr; gap: 8px; border-bottom: 1px solid rgba(0,0,0,0.06); padding-bottom: 4px; }
        .popup-prop:last-child { border-bottom: none; }
        .popup-prop span { color: var(--text-secondary); font-weight: 500; }

        /* Map Overlay Panel */
        .map-overlay-panel {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 320px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            pointer-events: auto;
        }

        .overlay-title { font-family: var(--font-display); font-size: 16px; font-weight: 700; margin-bottom: 6px; display: flex; justify-content: space-between; align-items: center; }
        .overlay-subtitle { font-size: 12px; color: var(--text-secondary); margin-bottom: 16px; line-height: 1.4; }
        
        .overlay-legend { border-top: 1px solid var(--border); padding-top: 16px; margin-top: 16px; }
        .legend-title { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; color: var(--text-muted); }
        .legend-item { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: 13px; }
        .legend-color { width: 16px; height: 16px; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1); background: var(--accent); }

        .btn-basemap-toggle {
            background: var(--bg-surface); border: 1px solid var(--border); border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .btn-basemap-toggle:hover { background: var(--accent-light); color: var(--accent); border-color: var(--accent); }


        /* ============================================
           PARTNERS SECTION
           ============================================ */
        .partners-section {
            padding: 40px 24px;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            position: relative;
        }

        .partners-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .partners-header h3 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 700;
        }

        .partners-track-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .partners-track-container::before,
        .partners-track-container::after {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 80px;
            z-index: 2;
            pointer-events: none;
        }

        .partners-track-container::before {
            left: 0;
            background: linear-gradient(to right, #ffffff, transparent);
        }

        .partners-track-container::after {
            right: 0;
            background: linear-gradient(to left, #ffffff, transparent);
        }

        .partners-track {
            display: flex;
            align-items: center;
            gap: 60px;
            width: max-content;
            animation: scrollPartners 30s linear infinite;
        }

        .partners-track:hover {
            animation-play-state: paused;
        }

        @keyframes scrollPartners {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .partner-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            filter: grayscale(100%) opacity(0.6);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
        }

        .partner-logo:hover {
            filter: grayscale(0%) opacity(1);
        }

        .partner-icon {
            width: 48px; height: 48px;
            background: var(--bg-surface);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            border: 1px solid var(--border);
            color: var(--accent);
        }

        .partner-text {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
            white-space: nowrap;
        }

        /* ============================================
           LEGAL SECTION
           ============================================ */
        .legal-section {
            padding: 100px 24px;
            background: var(--bg-surface);
        }

        .legal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .legal-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            gap: 16px;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .legal-card:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }

        .legal-icon {
            width: 52px; height: 52px;
            background: var(--accent-light);
            color: var(--accent);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .legal-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .legal-tag {
            font-size: 10px;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-muted);
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: inline-block;
            align-self: flex-start;
        }

        .legal-title {
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .legal-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .legal-download {
            font-size: 12px;
            font-weight: 600;
            color: var(--accent);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        /* ============================================
           TOPICS SECTION
           ============================================ */
        .topics-section {
            padding: 100px 24px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dim));
            position: relative;
            overflow: hidden;
            color: white;
        }

        .topics-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 2px, transparent 2px);
            background-size: 40px 40px;
            opacity: 1;
        }

        .topics-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .topics-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 700;
            margin-bottom: 16px;
            color: white;
            letter-spacing: -0.02em;
        }

        .topics-subtitle {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.9);
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        
        @media (min-width: 640px) {
            .topics-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .topics-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 24px;
            }
        }

        .topic-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            cursor: none;
        }

        .topic-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .topic-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .topic-card:hover .topic-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .topic-name {
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.02em;
            line-height: 1.4;
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .features-section {
            padding: 100px 24px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            cursor: none;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feature-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 30px var(--accent-muted);
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-card.featured {
            background: var(--green-deep);
            border-color: rgba(181,255,45,0.3);
            grid-column: span 2;
        }

        .feature-card.featured:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 50px rgba(181,255,45,0.1);
        }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--accent-muted);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 0 20px var(--accent-muted);
        }

        .feature-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            background: var(--accent-muted);
            color: var(--accent);
            border-radius: 6px;
            padding: 3px 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .feature-title {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            transition: gap 0.2s;
        }

        .feature-link:hover { gap: 10px; }

        /* Featured card inner layout */
        .feature-card.featured .feature-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: center;
        }

        .map-preview {
            background: rgba(0,0,0,0.3);
            border-radius: 12px;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border: 1px solid var(--border);
        }

        /* ============================================
           STATS SECTION
           ============================================ */
        .stats-section {
            padding: 100px 24px;
            background: linear-gradient(to bottom, transparent, var(--bg-surface), transparent);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto 60px;
        }

        .stat-item {
            background: var(--bg-card);
            padding: 40px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: background 0.3s;
        }

        .stat-item::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%; transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: var(--accent);
            transform-origin: center;
            transform: translateX(-50%) scaleX(0);
            transition: transform 0.4s;
        }

        .stat-item:hover { background: var(--bg-card-hover); }
        .stat-item:hover::after { transform: translateX(-50%) scaleX(1); }

        .stat-number {
            font-family: var(--font-display);
            font-size: 48px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-number .accent { color: var(--accent); }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        /* Chart bars */
        .chart-container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .chart-title {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 700;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .legend-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
        }

        .chart-bars {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            align-items: flex-end;
            height: 120px;
        }

        .chart-bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            height: 100%;
            justify-content: flex-end;
        }

        .chart-bar {
            width: 100%;
            background: var(--accent-muted);
            border: 1px solid var(--border);
            border-radius: 4px 4px 0 0;
            position: relative;
            overflow: hidden;
            transition: background 0.3s;
        }

        .chart-bar.active {
            background: linear-gradient(to top, var(--accent), #6eff99);
            border-color: var(--accent);
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .chart-bar:hover { background: rgba(181,255,45,0.3); cursor: none; }

        .chart-bar-label {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* ============================================
           DATASETS SECTION
           ============================================ */
        .datasets-section {
            padding: 100px 24px;
        }

        .dataset-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dataset-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            cursor: none;
        }

        .dataset-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }

        .dataset-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .dataset-category {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .cat-infra { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .cat-env { background: rgba(52,211,153,0.15); color: #34d399; }
        .cat-sosial { background: rgba(251,146,60,0.15); color: #fb923c; }

        .dataset-status {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); }

        .dataset-title {
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .dataset-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .dataset-meta {
            display: flex;
            gap: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ============================================
           CTA SECTION
           ============================================ */
        .cta-section {
            padding: 120px 24px;
        }

        .cta-box {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--green-deep), var(--bg-card));
            border: 1px solid rgba(181,255,45,0.25);
            border-radius: 32px;
            padding: 80px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -60%; left: 50%;
            transform: translateX(-50%);
            width: 600px; height: 400px;
            background: radial-gradient(ellipse, rgba(181,255,45,0.1), transparent 70%);
            pointer-events: none;
        }

        .cta-box::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 32px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(181,255,45,0.4), transparent, rgba(181,255,45,0.2));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .cta-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 18px;
            position: relative;
        }

        .cta-subtitle {
            font-size: 17px;
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto 40px;
            line-height: 1.7;
            position: relative;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            gap: 16px;
            position: relative;
        }

        /* ============================================
           FOOTER
           ============================================ */
        footer {
            border-top: 1px solid var(--border);
            padding: 60px 24px 40px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
        }

        .footer-logo-area .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 16px;
        }

        .footer-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.7;
            max-width: 280px;
        }

        .footer-col-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--accent); }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-copyright {
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-copyright span { color: var(--accent); }

        /* ============================================
           REVEAL ANIMATIONS
           ============================================ */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger delays */
        .reveal[data-delay="1"] { transition-delay: 0.1s; }
        .reveal[data-delay="2"] { transition-delay: 0.2s; }
        .reveal[data-delay="3"] { transition-delay: 0.3s; }
        .reveal[data-delay="4"] { transition-delay: 0.4s; }
        .reveal[data-delay="5"] { transition-delay: 0.5s; }

        /* ============================================
           DIVIDER
           ============================================ */
        .divider-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container { grid-template-columns: 1fr; }
            .hero-map-area { display: none; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .feature-card.featured { grid-column: span 1; }
            .feature-card.featured .feature-inner { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .dataset-cards-grid { grid-template-columns: 1fr 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 32px; }
        }

        @media (max-width: 640px) {
            nav { width: calc(100% - 24px); padding: 12px 16px; }
            .nav-links { display: none; }
            .features-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .dataset-cards-grid { grid-template-columns: 1fr; }
            .cta-box { padding: 48px 24px; }
            .footer-top { grid-template-columns: 1fr; }
        }
        /* ======================================
           THEMATIC MAPS LAYOUT SECTION
           ====================================== */
        .thematic-section {
            padding: 100px 5%;
            background: var(--bg-base);
            display: flex;
            align-items: center;
            gap: 60px;
        }
        .thematic-left {
            flex: 1;
            max-width: 400px;
        }
        .thematic-left h2 {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 20px;
        }
        .thematic-left p {
            font-size: 15px;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }
        .thematic-link {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            border-bottom: 1px solid transparent;
            transition: 0.3s;
        }
        .thematic-link:hover {
            border-bottom-color: var(--accent);
        }
        .thematic-right {
            flex: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        .tl-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .tl-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            box-shadow: 0 10px 30px rgba(181,255,45,0.1);
        }
        .tl-main {
            grid-column: 1 / 3;
            flex-direction: row;
        }
        .tl-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--border);
        }
        .tl-main img {
            width: 50%;
            height: 100%;
            border-bottom: none;
            border-right: 1px solid var(--border);
        }
        .tl-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--bg-card);
        }
        .tl-main .tl-content {
            width: 50%;
        }
        .tl-content h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .tl-main .tl-content h3 {
            font-size: 20px;
            color: var(--accent);
        }
        .tl-card-link {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tl-card-link:hover {
            color: var(--accent);
        }

        @media (max-width: 900px) {
            .thematic-section { flex-direction: column; }
            .thematic-left { max-width: 100%; text-align: center; }
            .thematic-right { grid-template-columns: 1fr; }
            .tl-main { grid-column: 1 / 2; flex-direction: column; }
            .tl-main img, .tl-main .tl-content { width: 100%; }
        }
    </style>
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-halo" id="cursorHalo"></div>

    <!-- Particle Canvas -->
    <canvas id="particles-canvas"></canvas>

    <!-- Navigation -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="nav-logo-icon">🗺️</div>
            <div>
                <div class="nav-logo-text">PetaKita <span>Aceh</span></div>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="active">Beranda</a></li>
            <li><a href="{{ url('/map?q=&layers=3%2C3&lat=5.09094&lng=96.34735&z=9') }}">Katalog Mapset</a></li>

            <li><a href="{{ url('/story-maps') }}">Story Maps</a></li>
            <li><a href="/katalog">Instansi</a></li>
        </ul>
    </nav>

    <!-- ======================================
         HERO SECTION
         ====================================== -->
    <section class="hero">
        <div class="hero-container">
            <h1 class="hero-title">Lebih mudah paham data lewat peta</h1>
            <p class="hero-subtitle">Dapatkan insight dengan cepat, untuk keputusan yang tepat</p>
            
            <form action="/map" method="GET" class="hero-search-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 14px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="q" placeholder="Cari Mapset..." autocomplete="off">
                <button type="submit" class="hero-search-btn" data-hover>
                    Jelajahi &rarr;
                </button>
            </form>
        </div>
    </section>

    <!-- ======================================
         PARTNERS SECTION
         ====================================== -->
    <section class="partners-section">
        <div class="partners-header">
            <h3>Mitra & Instansi Terintegrasi</h3>
        </div>
        <div class="partners-track-container">
            <div class="partners-track">
                <!-- Group 1 -->
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏛️</div>
                    <div class="partner-text">BAPPEDA Provinsi Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏥</div>
                    <div class="partner-text">Dinas Kesehatan</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏗️</div>
                    <div class="partner-text">Dinas PUPR</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌲</div>
                    <div class="partner-text">DLHK Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">📊</div>
                    <div class="partner-text">BPS Provinsi Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌾</div>
                    <div class="partner-text">Dinas Pertanian</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌊</div>
                    <div class="partner-text">BPBD Aceh</div>
                </a>
                
                <!-- Group 2 (Duplicate for seamless scroll) -->
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏛️</div>
                    <div class="partner-text">BAPPEDA Provinsi Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏥</div>
                    <div class="partner-text">Dinas Kesehatan</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🏗️</div>
                    <div class="partner-text">Dinas PUPR</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌲</div>
                    <div class="partner-text">DLHK Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">📊</div>
                    <div class="partner-text">BPS Provinsi Aceh</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌾</div>
                    <div class="partner-text">Dinas Pertanian</div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-icon">🌊</div>
                    <div class="partner-text">BPBD Aceh</div>
                </a>
            </div>
        </div>
    </section>

    <!-- ======================================
         FEATURES SECTION
         ====================================== -->
    <!-- ============================================
           INTERACTIVE MAP PREVIEW
           ============================================ -->
    <section class="interactive-map-section">
        <div class="section-header">
            <span class="section-label">Peta Tematik Interaktif</span>
            <h2 class="section-title">Eksplorasi Spasial Langsung</h2>
            <p class="section-subtitle">Coba langsung pengalaman menggunakan WebGIS kami. Klik pada area atau titik di bawah ini untuk melihat detail informasi spasial.</p>
        </div>

        <div class="map-preview-container">
            <div id="homeMap"></div>
            
            <div class="map-overlay-panel">
                <div class="overlay-title">
                    <span id="preview-layer-name">Memuat Data...</span>
                    <button class="btn-basemap-toggle" id="btn-home-basemap">🗺️ Basemap: Light</button>
                </div>
                <div class="overlay-subtitle" id="preview-layer-agency">Instansi: -</div>
                
                <div style="font-size: 13px; color: var(--text-primary); margin-bottom: 8px;">
                    <strong>Geometri:</strong> <span id="preview-layer-geom">-</span>
                </div>
                <div style="font-size: 13px; color: var(--text-primary); margin-bottom: 8px;">
                    <strong>Fitur Spasial:</strong> <span id="preview-layer-count">0</span>
                </div>

                <div class="overlay-legend">
                    <div class="legend-title">Legenda Visual</div>
                    <div class="legend-item">
                        <div class="legend-color" id="preview-legend-color"></div>
                        <span id="preview-legend-text">Data Spasial</span>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ======================================
         THEMATIC MAPS LAYOUT SECTION
         ====================================== -->
    <section class="thematic-section">
        <div class="thematic-left reveal">
            <h2>Peta Tematik Layout</h2>
            <p>Eksplorasi peta dengan ragam tema, lengkap dengan informasi umum dan metadata.</p>
            <a href="#" class="thematic-link">Lihat Lainnya</a>
        </div>
        <div class="thematic-right reveal" data-delay="1">
            @if(isset($featuredThematics) && $featuredThematics->count() > 0)
                @foreach($featuredThematics as $index => $map)
                    <div class="tl-card {{ $index === 0 ? 'tl-main' : '' }}">
                        <img src="{{ $map->thumbnail ? Storage::url($map->thumbnail) : 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400"><rect width="600" height="400" fill="%231a7f4f"/><path d="M0,250 Q150,180 300,240 T600,200 L600,400 L0,400 Z" fill="%23155f3a"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="%23ffffff" font-family="sans-serif" font-size="24" font-weight="bold">PetaKita Aceh</text></svg>' }}" alt="{{ $map->title }}">
                        <div class="tl-content">
                            <h3>{{ $map->title }}</h3>
                            @if($index === 0)
                                <a href="/tematik?visualization-type=layout" class="tl-card-link">Baca Selengkapnya &rarr;</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div style="color:var(--text-muted); padding:20px;">Belum ada data peta tematik.</div>
            @endif
        </div>
    </section>

    <div class="divider-line"></div>

    <!-- ======================================
         STORY MAPS SECTION
         ====================================== -->
    <section class="thematic-section" style="background: var(--bg-surface);">
        <div class="thematic-left reveal">
            <h2>Story Maps</h2>
            <p>Pemanfaatan dataset geospasial yang disajikan dalam bentuk teks cerita, peta interaktif, dan konten multimedia lain.</p>
            <a href="/story-maps" class="thematic-link">Lihat Lainnya</a>
        </div>
        <div class="thematic-right reveal" data-delay="1">
            @if(isset($featuredStoryMaps) && $featuredStoryMaps->count() > 0)
                @foreach($featuredStoryMaps->take(3) as $index => $smap)
                    <div class="tl-card {{ $index === 0 ? 'tl-main' : '' }}">
                        <img src="{{ $smap->cover_image ? Storage::url($smap->cover_image) : 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400"><rect width="600" height="400" fill="%231a7f4f"/><path d="M0,250 Q150,180 300,240 T600,200 L600,400 L0,400 Z" fill="%23155f3a"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="%23ffffff" font-family="sans-serif" font-size="24" font-weight="bold">PetaKita Aceh</text></svg>' }}" alt="{{ $smap->title }}">
                        <div class="tl-content">
                            <h3>{{ $smap->title }}</h3>
                            @if($index === 0)
                                <a href="{{ $smap->url ?? route('story-maps.show', $smap->slug) }}" class="tl-card-link" @if($smap->url) target="_blank" @endif>Baca Selengkapnya &rarr;</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div style="color:var(--text-muted); padding:20px;">Belum ada data story map.</div>
            @endif
        </div>
    </section>

    <div class="divider-line"></div>

    <!-- ======================================
         STATS SECTION
         ====================================== -->
    <section class="stats-section">
        <div class="section-container">
            <div class="section-header reveal">
                <div class="section-label">📊 Insight Data</div>
                <h2 class="section-title">Platform Skala Provinsi</h2>
                <p class="section-subtitle">Angka nyata di balik ekosistem data spasial Aceh yang terus bertumbuh.</p>
            </div>

            <div class="stats-grid reveal">
                <div class="stat-item" data-hover>
                    <div class="stat-number"><span class="accent" data-count="{{ $countDataset ?? 0 }}">0</span></div>
                    <div class="stat-label">Dataset Publik</div>
                </div>
                <div class="stat-item" data-hover>
                    <div class="stat-number"><span class="accent" data-count="{{ $countAgency ?? 0 }}">0</span></div>
                    <div class="stat-label">Instansi/OPD</div>
                </div>
                <div class="stat-item" data-hover>
                    <div class="stat-number"><span class="accent" data-count="{{ $countLayer ?? 0 }}">0</span></div>
                    <div class="stat-label">Layer Aktif</div>
                </div>
                <div class="stat-item" data-hover>
                    <div class="stat-number"><span class="accent" data-count="{{ $countDownload ?? 0 }}">0</span></div>
                    <div class="stat-label">Unduhan/Bulan</div>
                </div>
            </div>

            <!-- Chart -->
            <div class="chart-container reveal">
                <div class="chart-header">
                    <div class="chart-title">📈 Dataset Diunggah per Bulan (2026)</div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--accent)"></div>
                            <span>Dataset Baru</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#60a5fa"></div>
                            <span>Dataset Diperbarui</span>
                        </div>
                    </div>
                </div>
                <div class="chart-bars">
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:55%"></div>
                        <div class="chart-bar" style="height:40%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Feb</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:70%"></div>
                        <div class="chart-bar" style="height:55%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Mar</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:60%"></div>
                        <div class="chart-bar" style="height:45%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Apr</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:85%"></div>
                        <div class="chart-bar" style="height:70%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Mei</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:75%"></div>
                        <div class="chart-bar" style="height:60%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Jun</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height:90%"></div>
                        <div class="chart-bar" style="height:75%;background:rgba(96,165,250,0.2);border-color:rgba(96,165,250,0.2)"></div>
                        <div class="chart-bar-label">Jul</div>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar active" style="height:100%"></div>
                        <div class="chart-bar" style="height:85%;background:rgba(96,165,250,0.4);border-color:rgba(96,165,250,0.4)"></div>
                        <div class="chart-bar-label">Ags</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="divider-line"></div>

    <!-- ======================================
         DATASETS SECTION
         ====================================== -->
    <section class="datasets-section">
        <div class="section-header reveal">
            <div class="section-label">🗂️ Dataset Unggulan</div>
            <h2 class="section-title">Data Terpopuler</h2>
            <p class="section-subtitle">Dataset yang paling banyak diakses dan diunduh oleh pengguna portal.</p>
        </div>

        <div class="dataset-cards-grid">
            <div class="dataset-card reveal" data-delay="1" data-hover>
                <div class="dataset-card-header">
                    <span class="dataset-category cat-infra">Infrastruktur</span>
                    <div class="dataset-status"><div class="status-dot"></div>Published</div>
                </div>
                <h4 class="dataset-title">Jaringan Jalan Provinsi Aceh 2026</h4>
                <p class="dataset-desc">Data ruas jalan provinsi mencakup 27 kabupaten/kota dengan klasifikasi fungsi dan kondisi jalan.</p>
                <div class="dataset-meta">
                    <div class="meta-item">📦 GeoJSON</div>
                    <div class="meta-item">👁️ 12.4K views</div>
                    <div class="meta-item">⬇️ 3.2K unduh</div>
                </div>
            </div>

            <div class="dataset-card reveal" data-delay="2" data-hover>
                <div class="dataset-card-header">
                    <span class="dataset-category cat-env">Lingkungan</span>
                    <div class="dataset-status"><div class="status-dot"></div>Published</div>
                </div>
                <h4 class="dataset-title">Peta Kawasan Hutan Lindung Aceh</h4>
                <p class="dataset-desc">Batas dan atribut kawasan hutan lindung, hutan produksi, dan area konservasi seluruh Aceh.</p>
                <div class="dataset-meta">
                    <div class="meta-item">📦 Shapefile</div>
                    <div class="meta-item">👁️ 9.8K views</div>
                    <div class="meta-item">⬇️ 2.7K unduh</div>
                </div>
            </div>

            <div class="dataset-card reveal" data-delay="3" data-hover>
                <div class="dataset-card-header">
                    <span class="dataset-category cat-sosial">Sosial</span>
                    <div class="dataset-status"><div class="status-dot"></div>Published</div>
                </div>
                <h4 class="dataset-title">Distribusi Kepadatan Penduduk 2025</h4>
                <p class="dataset-desc">Heatmap kepadatan penduduk per kecamatan berdasarkan sensus terbaru BPS Aceh.</p>
                <div class="dataset-meta">
                    <div class="meta-item">📦 GeoJSON</div>
                    <div class="meta-item">👁️ 8.1K views</div>
                    <div class="meta-item">⬇️ 1.9K unduh</div>
                </div>
            </div>
        </div>
    </section>

    <div class="divider-line"></div>

    <!-- ======================================
         LEGAL SECTION
         ====================================== -->
    <section class="legal-section">
        <div class="section-header reveal">
            <div class="section-label">📜 Produk Hukum</div>
            <h2 class="section-title">Regulasi Spasial</h2>
            <p class="section-subtitle">Landasan hukum penyelenggaraan Satu Data dan Informasi Geospasial di lingkungan Pemerintah Provinsi Aceh.</p>
        </div>

        <div class="legal-grid reveal" data-delay="1">
            <a href="#" class="legal-card" data-hover>
                <div class="legal-icon">📄</div>
                <div class="legal-content">
                    <span class="legal-tag">Perpres</span>
                    <h4 class="legal-title">Peraturan Presiden Nomor 39 Tahun 2019</h4>
                    <p class="legal-desc">Tentang Satu Data Indonesia (SDI) sebagai pedoman tata kelola data pemerintah.</p>
                    <div class="legal-download">
                        ↓ Unduh Dokumen (PDF)
                    </div>
                </div>
            </a>
            
            <a href="#" class="legal-card" data-hover>
                <div class="legal-icon">📄</div>
                <div class="legal-content">
                    <span class="legal-tag">Perpres</span>
                    <h4 class="legal-title">Peraturan Presiden Nomor 27 Tahun 2014</h4>
                    <p class="legal-desc">Tentang Jaringan Informasi Geospasial Nasional (JIGN).</p>
                    <div class="legal-download">
                        ↓ Unduh Dokumen (PDF)
                    </div>
                </div>
            </a>

            <a href="#" class="legal-card" data-hover>
                <div class="legal-icon">📜</div>
                <div class="legal-content">
                    <span class="legal-tag">Pergub</span>
                    <h4 class="legal-title">Peraturan Gubernur Aceh Nomor XX Tahun 202X</h4>
                    <p class="legal-desc">Tentang Penyelenggaraan Simpul Jaringan Informasi Geospasial Aceh.</p>
                    <div class="legal-download">
                        ↓ Unduh Dokumen (PDF)
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- ======================================
         TOPICS SECTION
         ====================================== -->
    <section class="topics-section">
        <div class="topics-header reveal">
            <h2 class="topics-title">Pilih Topik yang Kamu Sukai!</h2>
            <p class="topics-subtitle">Telusuri ragam topik yang tersedia!</p>
        </div>
        <div class="topics-grid reveal" data-delay="1">
            <a href="/katalog?topic=pendidikan" class="topic-card" data-hover>
                <div class="topic-icon">🎓</div>
                <div class="topic-name">Pendidikan</div>
            </a>
            <a href="/katalog?topic=kesehatan" class="topic-card" data-hover>
                <div class="topic-icon">🩺</div>
                <div class="topic-name">Kesehatan</div>
            </a>
            <a href="/katalog?topic=ekonomi" class="topic-card" data-hover>
                <div class="topic-icon">💼</div>
                <div class="topic-name">Ekonomi</div>
            </a>
            <a href="/katalog?topic=infrastruktur" class="topic-card" data-hover>
                <div class="topic-icon">🏗️</div>
                <div class="topic-name">Infrastruktur</div>
            </a>
            <a href="/katalog?topic=kependudukan" class="topic-card" data-hover>
                <div class="topic-icon">🪪</div>
                <div class="topic-name">Kependudukan</div>
            </a>
            <a href="/katalog?topic=pemerintah-desa" class="topic-card" data-hover>
                <div class="topic-icon">🏛️</div>
                <div class="topic-name">Pemerintah & Desa</div>
            </a>
            <a href="/katalog?topic=lingkungan-hidup" class="topic-card" data-hover>
                <div class="topic-icon">🌱</div>
                <div class="topic-name">Lingkungan Hidup</div>
            </a>
            <a href="/katalog?topic=sosial" class="topic-card" data-hover>
                <div class="topic-icon">🤝</div>
                <div class="topic-name">Sosial</div>
            </a>
            <a href="/katalog?topic=tata-ruang" class="topic-card" data-hover>
                <div class="topic-icon">📐</div>
                <div class="topic-name">Tata Ruang</div>
            </a>
            <a href="/katalog?topic=rencana-struktur-ruang" class="topic-card" data-hover>
                <div class="topic-icon">🗺️</div>
                <div class="topic-name">Rencana Struktur Ruang</div>
            </a>
        </div>
    </section>

    <!-- ======================================
         CTA SECTION
         ====================================== -->
    <section class="cta-section">
        <div class="cta-box reveal">
            <h2 class="cta-title" style="margin-bottom: 0;">Data Spasial Terbuka<br><span class="hero-title-accent">Untuk Semua</span></h2>
        </div>
    </section>

    <!-- ======================================
         FOOTER
         ====================================== -->
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-logo-area">
                    <a href="/" class="footer-logo">
                        <div class="nav-logo-icon">🗺️</div>
                        <div class="nav-logo-text">PetaKita <span>Aceh</span></div>
                    </a>
                    <p class="footer-desc">Platform geoportal resmi Pemerintah Provinsi Aceh untuk data spasial yang terpadu, terbuka, dan dapat diakses semua pihak.</p>
                </div>
                <div>
                    <div class="footer-col-title">Platform</div>
                    <ul class="footer-links">
                        <li><a href="#">WebGIS Viewer</a></li>
                        <li><a href="{{ url('/katalog') }}">Katalog Dataset</a></li>
                        <li><a href="/story-maps/menjelajah-keindahan-jawa-barat">Story Maps</a></li>
                        <li><a href="#">API Publik</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Tentang</div>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Portal</a></li>
                        <li><a href="#">Instansi Penyedia</a></li>
                        <li><a href="#">Kebijakan Data</a></li>
                        <li><a href="#">Standar Metadata</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Dukungan</div>
                    <ul class="footer-links">
                        <li><a href="#">Panduan Penggunaan</a></li>
                        <li><a href="#">Dokumentasi API</a></li>
                        <li><a href="#">Laporkan Masalah</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-copyright">
                    © 2026 <span>PetaKita Aceh</span> — Pemerintah Provinsi Aceh
                </div>
                <div style="font-size:12px;color:var(--text-muted)">
                    Dibangun dengan 💚 untuk Aceh
                </div>
            </div>
        </div>
    </footer>

    <script>
    // ============================================
    // CUSTOM CURSOR
    // ============================================
    const cursorDot = document.getElementById('cursorDot');
    const cursorHalo = document.getElementById('cursorHalo');
    let mouseX = 0, mouseY = 0;
    let haloX = 0, haloY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        cursorDot.style.left = mouseX + 'px';
        cursorDot.style.top = mouseY + 'px';
    });

    function animateHalo() {
        haloX += (mouseX - haloX) * 0.12;
        haloY += (mouseY - haloY) * 0.12;
        cursorHalo.style.left = haloX + 'px';
        cursorHalo.style.top = haloY + 'px';
        requestAnimationFrame(animateHalo);
    }
    animateHalo();

    document.querySelectorAll('[data-hover], a, button, .feature-card, .dataset-card, .stat-item').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
    });

    // ============================================
    // PARTICLES
    // ============================================
    const canvas = document.getElementById('particles-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    class Particle {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 1.5 + 0.3;
            this.speedX = (Math.random() - 0.5) * 0.4;
            this.speedY = (Math.random() - 0.5) * 0.4;
            this.opacity = Math.random() * 0.5 + 0.1;
            this.color = Math.random() > 0.6 ? '#b5ff2d' : '#1a3d2b';
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.reset();
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.opacity;
            ctx.fill();
        }
    }

    for (let i = 0; i < 80; i++) particles.push(new Particle());

    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        ctx.globalAlpha = 1;
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    // ============================================
    // SCROLL REVEAL
    // ============================================
    const revealEls = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(el => {
            if (el.isIntersecting) {
                el.target.classList.add('visible');
                observer.unobserve(el.target);
            }
        });
    }, { threshold: 0.1 });
    revealEls.forEach(el => observer.observe(el));

    // ============================================
    // COUNTER ANIMATION
    // ============================================
    function animateCounter(el, target, suffix = '') {
        const duration = 2000;
        const startTime = performance.now();
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString() + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-count'));
                const suffix = el.getAttribute('data-suffix') || '';
                animateCounter(el, target, suffix);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

    // ============================================
    // 3D TILT ON HOVER
    // ============================================
    document.querySelectorAll('.feature-card, .dataset-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const dx = (e.clientX - cx) / rect.width;
            const dy = (e.clientY - cy) / rect.height;
            card.style.transform = `perspective(800px) rotateY(${dx * 8}deg) rotateX(${-dy * 8}deg) translateY(-4px) scale(1.01)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    // ============================================
    // PARALLAX ON SCROLL
    // ============================================
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const heroBg = document.querySelector('.hero-grid-bg');
        const heroGlow = document.querySelector('.hero-glow');
        if (heroBg) heroBg.style.transform = `translateY(${scrollY * 0.3}px)`;
        if (heroGlow) heroGlow.style.transform = `translate(-50%, calc(-50% + ${scrollY * 0.15}px))`;
    });

    // Nav shadow on scroll
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('nav');
        if (window.scrollY > 50) {
            nav.style.background = 'rgba(255,255,255,0.95)';
        } else {
            nav.style.background = 'var(--glass-bg)';
        }
    });
    </script>

    <!-- Leaflet & Leaflet-Measure Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-measure/dist/leaflet-measure.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // ============================================
        // INTERACTIVE MAP PREVIEW ON HOMEPAGE
        // ============================================
        const homeMapEl = document.getElementById('homeMap');
        if (!homeMapEl) return;

        // 1. Initialize Map
        const homeMap = L.map('homeMap', {
            center: [5.5483, 95.3238], // Bandung
            zoom: 8,
            zoomControl: false
        });

        L.control.zoom({ position: 'bottomright' }).addTo(homeMap);

        // Measurement Tool
        const measureControl = new L.Control.Measure({
            position: 'bottomleft',
            primaryLengthUnit: 'meters', secondaryLengthUnit: 'kilometers',
            primaryAreaUnit: 'sqmeters', secondaryAreaUnit: 'hectares',
            activeColor: '#1a7f4f', completedColor: '#155f3a'
        });
        measureControl.addTo(homeMap);

        // 2. Basemaps
        const basemaps = {
            light: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', { attribution: '&copy; CARTO' }),
            satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: '&copy; Esri' }),
            osm: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' })
        };
        
        let currentBasemap = 'light';
        basemaps.light.addTo(homeMap);

        // Basemap Switcher
        const btnBasemap = document.getElementById('btn-home-basemap');
        const cycle = ['light', 'satellite', 'osm'];
        btnBasemap.addEventListener('click', () => {
            homeMap.removeLayer(basemaps[currentBasemap]);
            currentBasemap = cycle[(cycle.indexOf(currentBasemap) + 1) % cycle.length];
            basemaps[currentBasemap].addTo(homeMap);
            
            const labels = { 'light': 'Light', 'satellite': 'Satelit', 'osm': 'OSM' };
            btnBasemap.innerText = `🗺️ Basemap: ${labels[currentBasemap]}`;
        });

        // 3. Fetch Data & Display
        async function loadPreviewDataset() {
            try {
                // Fetch datasets
                const res = await fetch('/api/datasets');
                const jsonRes = await res.json();
                const datasets = jsonRes.data || [];
                
                if (datasets.length > 0) {
                    // Temukan dataset batas kabupaten atau ambil yang pertama jika tidak ada
                    const ds = datasets.find(d => d.slug === 'batas-kabupaten-kota-aceh-riil') || datasets[0];
                    document.getElementById('preview-layer-name').innerText = ds.title;
                    document.getElementById('preview-layer-agency').innerText = ds.agency ? `Instansi: ${ds.agency.name}` : '-';
                    
                    const layers = ds.layers || [];
                    
                    if (layers.length > 0) {
                        const targetLayer = layers[0];
                        document.getElementById('preview-layer-name').innerText = targetLayer.name;
                        
                        // Load GeoJSON
                        const geoRes = await fetch(`/api/layers/${targetLayer.id}/geojson`);
                        const geoJson = await geoRes.json();
                        
                        let featureCount = 0;
                        let geomType = '-';
                        
                        const geoLayer = L.geoJSON(geoJson, {
                            style: function(feature) {
                                return {
                                    color: '#1a7f4f',
                                    weight: 2,
                                    opacity: 1,
                                    fillColor: '#1a7f4f',
                                    fillOpacity: 0.4
                                };
                            },
                            onEachFeature: function(feature, layer) {
                                featureCount++;
                                if(geomType === '-') geomType = feature.geometry.type;

                                let popupHtml = `<div class="popup-title">${targetLayer.name}</div>`;
                                if (feature.properties) {
                                    for (const [key, val] of Object.entries(feature.properties)) {
                                        if (key !== 'id' && key !== 'layer_id') {
                                            const formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                                            popupHtml += `<div class="popup-prop"><span>${formattedKey}</span><strong>${val}</strong></div>`;
                                        }
                                    }
                                }
                                layer.bindPopup(popupHtml);
                            }
                        }).addTo(homeMap);
                        
                        if(featureCount > 0) {
                            // Keep map centered on West Java instead of zooming out bounds
                            homeMap.setView([5.5483, 95.3238], 8);
                            document.getElementById('preview-layer-count').innerText = featureCount;
                            document.getElementById('preview-layer-geom').innerText = geomType;
                        }
                    } else {
                        document.getElementById('preview-layer-name').innerText = "Belum Ada Layer Peta";
                    }
                } else {
                    document.getElementById('preview-layer-name').innerText = "Belum Ada Dataset";
                }
            } catch (err) {
                console.error("Error loading preview map", err);
                document.getElementById('preview-layer-name').innerText = "Gagal memuat data";
            }
        }
        
        loadPreviewDataset();
    });
    </script>
</body>
</html>

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/css/app.css

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol', 'Noto Color Emoji';
}

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/js/app.js

```javascript
import './bootstrap';

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/resources/js/bootstrap.js

```javascript
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/routes/api.php

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DatasetController;
use App\Http\Controllers\Api\LayerController;
use App\Http\Controllers\Api\StoryMapController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('datasets')->group(function () {
    Route::get('/', [DatasetController::class, 'index']);
    Route::get('/{slug}', [DatasetController::class, 'show']);
});

Route::prefix('layers')->group(function () {
    Route::get('/{id}/geojson', [LayerController::class, 'geojson'])->middleware('throttle:30,1');
    Route::get('/{id}/download', [LayerController::class, 'downloadGeoJson'])->middleware('throttle:10,1');
});

Route::prefix('story-maps')->group(function () {
    Route::get('/', [StoryMapController::class, 'index']);
    Route::get('/{slug}', [StoryMapController::class, 'show']);
});

// API v2 Endpoints (sig.acehprov.go.id/api/v2)
Route::prefix('v2')->middleware('throttle:60,1')->group(function () {
    Route::get('/datasets', [DatasetController::class, 'indexV2']);
    Route::get('/datasets/{slug}', [DatasetController::class, 'showV2']);
    Route::get('/external/bnpb-disaster', function () {
        $service = app(\App\Services\SigAcehIntegrationService::class);
        $res = $service->syncNationalBnpbData();
        return response()->json([
            'status' => 'success',
            'provider' => 'BNPB Indonesia / BPBA Aceh',
            'message' => $res['message'],
            'count' => $res['count'],
        ]);
    });
});

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/routes/console.php

```php
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi otomatis data peta SIG Aceh (143 dataset) & BNPB setiap hari
Schedule::command('sig:sync-aceh')->daily();

```

## File: D:/webgis/peta-kita-aceh/peta-kita-aceh/routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThematicMapController;

Route::get('/', function () {
    $featuredDatasets = App\Models\Dataset::where('status', 'published')->latest()->take(3)->get();
    $featuredThematics = App\Models\ThematicMap::where('status', 'published')->where('type', 'layout')->latest()->take(3)->get();
    $featuredStoryMaps = App\Models\StoryMap::where('status', 'published')->latest()->take(3)->get();
    
    // Get actual stats for the landing page
    $countDataset = App\Models\Dataset::where('status', 'published')->count();
    $countAgency = App\Models\Agency::count();
    $countLayer = App\Models\Layer::count();
    $countDownload = App\Models\DatasetDownload::count(); 
    
    return view('welcome', compact('featuredDatasets', 'featuredThematics', 'featuredStoryMaps', 'countDataset', 'countAgency', 'countLayer', 'countDownload'));
});

Route::get('/map', function (Illuminate\Http\Request $request) {
    $tematikConfig = null;
    $tematikMeta = null;
    if ($request->has('tematik_id')) {
        $tematik = \App\Models\ThematicMap::find($request->tematik_id);
        if ($tematik && $tematik->type === 'interactive') {
            $tematikConfig = $tematik->config_json;
            $tematikMeta = [
                'title' => $tematik->title,
                'description' => $tematik->description,
                'agency' => $tematik->agency ? $tematik->agency->name : 'Pemerintah Aceh'
            ];
        }
    }
    return view('viewer', compact('tematikConfig', 'tematikMeta'));
});

Route::get('/katalog', [\App\Http\Controllers\CatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{slug}', [\App\Http\Controllers\CatalogController::class, 'show'])->name('katalog.show');

Route::get('/story-maps', [\App\Http\Controllers\StoryMapController::class, 'index'])->name('story-maps.index');
Route::get('/story-maps/{slug}', [\App\Http\Controllers\StoryMapController::class, 'show'])->name('story-maps.show');

Route::get('/tematik', [ThematicMapController::class, 'index'])->name('tematik.index');

Route::get('/dokumentasi-api', [\App\Http\Controllers\ApiDocumentationController::class, 'index']);

Route::get('/standar-metadata', function () {
    return view('docs-metadata');
});

```

## File: vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

```

## File: package.json

```json
{
    "$schema": "https://www.schemastore.org/package.json",
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "axios": "^1.11.0",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^2.0.0",
        "tailwindcss": "^4.0.0",
        "vite": "^7.0.7"
    }
}

```

