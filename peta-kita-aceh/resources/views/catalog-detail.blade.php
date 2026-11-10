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
            <a href="{{ url('/standar-metadata') }}" class="nav-link">Standar Metadata</a>
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

                <div class="sidebar-card" style="border-left: 4px solid var(--accent);">
                    <div style="font-size: 11px; font-weight: 700; color: var(--accent); text-transform: uppercase; margin-bottom: 4px;">Standar Geospasial</div>
                    <h3>📄 Metadata SNI ISO 19115</h3>
                    <p>Unduh berkas metadata resmi berstandar nasional (ISO 19139 XML) untuk interoperabilitas data spasial Satu Peta.</p>
                    <a href="{{ route('katalog.metadata.xml', $dataset->slug) }}" class="btn btn-primary" style="width: 100%; justify-content: center; margin-bottom: 8px;" download>
                        ↓ Unduh Metadata XML
                    </a>
                    <a href="{{ url('/standar-metadata') }}" class="btn btn-ghost" style="width: 100%; justify-content: center; font-size: 12px;">
                        Pelajari Standar SNI →
                    </a>
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
