<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standar Metadata SNI ISO 19115 — PetaKita Aceh</title>
    <meta name="description" content="Pedoman teknis standar metadata geospasial SNI ISO 19115:2012 dan ISO 19139 Pemerintah Provinsi Aceh untuk kebijakan Satu Peta dan Satu Data Indonesia.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-base: #f4f6fb;
            --bg-surface: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f9fafb;
            --accent: #1a7f4f;
            --accent-dim: #13623d;
            --accent-light: #e6f5ed;
            --accent-glow: rgba(26, 127, 79, 0.2);
            --gold: #d97706;
            --gold-light: #fef3c7;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: rgba(0, 0, 0, 0.08);
            --border-hover: rgba(26, 127, 79, 0.35);
            --glass-bg: rgba(255, 255, 255, 0.88);
            --glass-border: rgba(26, 127, 79, 0.15);
            --code-bg: #0f172a;
            --code-text: #e2e8f0;
            --font-main: 'Inter', sans-serif;
            --font-display: 'Space Grotesk', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-base);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ================= NAVIGATION ================= */
        nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .nav-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dim));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .nav-logo-text {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.02em;
        }

        .nav-logo-text span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }

        .nav-link {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--accent);
            background: var(--accent-light);
        }

        .nav-link.active {
            color: var(--accent);
            background: var(--accent-light);
            font-weight: 600;
        }

        .btn-nav-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #ffffff !important;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        .btn-nav-primary:hover {
            background: var(--accent-dim);
            transform: translateY(-1px);
        }

        /* ================= HERO HEADER ================= */
        .hero {
            position: relative;
            background: linear-gradient(135deg, #093721 0%, #155f3a 50%, #1a7f4f 100%);
            color: #ffffff;
            padding: 64px 24px 72px;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.5;
            pointer-events: none;
        }

        .hero-container {
            max-width: 1100px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-badge-wrap {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            backdrop-filter: blur(8px);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .hero-desc {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 800px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: var(--accent);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .btn-hero-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(8px);
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* ================= MAIN CONTENT ================= */
        .main-container {
            max-width: 1100px;
            margin: -32px auto 60px;
            padding: 0 24px;
            position: relative;
            z-index: 2;
            flex: 1;
            width: 100%;
        }

        /* Quick Stat Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.06);
            border-color: var(--border-hover);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            background: var(--accent-light);
            color: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .stat-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-val {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.4;
        }

        .stat-desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* Content Sections */
        .content-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 28px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-pill {
            font-size: 11px;
            font-weight: 600;
            background: var(--accent-light);
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Filter Box for Table */
        .table-search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-base);
            border: 1px solid var(--border);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            width: 260px;
        }

        .table-search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-family: inherit;
            font-size: 13px;
            color: var(--text-primary);
        }

        /* Responsive Table */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            text-align: left;
        }

        .meta-table th {
            background: #f8fafc;
            color: var(--text-secondary);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .meta-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .meta-table tbody tr:hover {
            background: #f8fafc;
        }

        .meta-table tbody tr:last-child td {
            border-bottom: none;
        }

        .tag-badge {
            font-family: var(--font-mono);
            font-size: 12px;
            color: #0369a1;
            background: #e0f2fe;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .status-required {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-recommended {
            background: #fef3c7;
            color: #b45309;
        }

        /* Code Viewer Tabs */
        .tab-nav {
            display: flex;
            gap: 6px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 16px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 10px 18px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: var(--accent);
        }

        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .code-container {
            position: relative;
            background: var(--code-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #090d16;
            padding: 10px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: #94a3b8;
            font-size: 12px;
            font-family: var(--font-mono);
        }

        .btn-copy-code {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-copy-code:hover {
            background: rgba(255,255,255,0.2);
        }

        pre code {
            display: block;
            padding: 20px;
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--code-text);
            line-height: 1.6;
            overflow-x: auto;
            max-height: 480px;
        }

        /* Validator Playground */
        .validator-box {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .validator-textarea {
            width: 100%;
            height: 180px;
            font-family: var(--font-mono);
            font-size: 12.5px;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: var(--text-primary);
            resize: vertical;
            outline: none;
            transition: border-color 0.2s;
            margin-bottom: 14px;
        }

        .validator-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .validator-results {
            margin-top: 20px;
            display: none;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px 20px;
        }

        .result-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed var(--border);
            font-size: 13px;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        /* Workflow Steps */
        .workflow-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .workflow-step {
            position: relative;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
        }

        .step-num {
            width: 28px;
            height: 28px;
            background: var(--accent);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .step-title {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* ================= FOOTER ================= */
        footer {
            background: #ffffff;
            border-top: 1px solid var(--border);
            padding: 40px 24px 24px;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 20px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-bottom a {
            color: var(--text-secondary);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: var(--accent);
        }

        /* Toast notification */
        .toast-notif {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 99999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast-notif.show {
            transform: translateY(0);
            opacity: 1;
        }

        @media (max-width: 768px) {
            nav {
                padding: 12px 16px;
            }
            .nav-links {
                display: none;
            }
            .hero {
                padding: 40px 16px 56px;
            }
            .main-container {
                padding: 0 16px;
            }
            .content-card {
                padding: 20px;
            }
            .table-search-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Toast Notification -->
    <div id="toastNotif" class="toast-notif">
        <span id="toastIcon">📋</span>
        <span id="toastMsg">Teks berhasil disalin ke clipboard!</span>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="nav-logo-icon">🗺️</div>
            <div class="nav-logo-text">PetaKita <span>Aceh</span></div>
        </a>
        <ul class="nav-links">
            <li><a href="/" class="nav-link">Beranda</a></li>
            <li><a href="/katalog" class="nav-link">Katalog Data</a></li>
            <li><a href="/map" class="nav-link">WebGIS Viewer</a></li>
            <li><a href="/story-maps" class="nav-link">Story Maps</a></li>
            <li><a href="/dokumentasi-api" class="nav-link">API Publik</a></li>
            <li><a href="/standar-metadata" class="nav-link active">Standar Metadata</a></li>
        </ul>
        <div>
            <a href="/admin/login" class="btn-nav-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                Portal SKPA
            </a>
        </div>
    </nav>

    <!-- Hero Header -->
    <header class="hero">
        <div class="hero-container">
            <div class="hero-badge-wrap">
                <span>🏛️ STANDAR NASIONAL INDONESIA (BIG)</span>
                <span>•</span>
                <span>SNI ISO 19115:2012</span>
            </div>
            <h1 class="hero-title">Standar Metadata Geospasial Aceh</h1>
            <p class="hero-desc">
                Pedoman struktur data, skema XML (ISO 19139), dan ketentuan metadata resmi untuk mewujudkan <strong>Kebijakan Satu Peta (One Map Policy)</strong> dan interoperabilitas data spasial antar-SKPA Pemerintah Provinsi Aceh.
            </p>
            <div class="hero-actions">
                <button type="button" class="btn-hero btn-hero-primary" onclick="downloadXmlTemplate()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Unduh Template XML Resmi
                </button>
                <a href="#codePreviewSection" class="btn-hero btn-hero-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    Lihat Skema XML (GMD)
                </a>
                <a href="#validatorSection" class="btn-hero btn-hero-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    Uji XML Validator
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Stat / Pillar Cards -->
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon">📑</div>
                <div class="stat-title">Identifikasi & Sitasi</div>
                <div class="stat-val">ISO 19115 Core</div>
                <div class="stat-desc">Judul, abstrak, tujuan, dan klasifikasi topik tema geospasial Aceh.</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🌐</div>
                <div class="stat-title">Referensi Spasial</div>
                <div class="stat-val">EPSG:4326 (WGS 84)</div>
                <div class="stat-desc">Cakupan BBOX koordinat geografis bujur 95.00°–98.50° & lintang 2.00°–6.00°.</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📜</div>
                <div class="stat-title">Silsilah & Mutu Data</div>
                <div class="stat-val">Lineage & Accuracy</div>
                <div class="stat-desc">Riwayat akuisisi data, skala representasi (1:25.000 / 1:50.000), dan metodologi.</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏛️</div>
                <div class="stat-title">Penanggung Jawab</div>
                <div class="stat-val">Point of Contact SKPA</div>
                <div class="stat-desc">Instansi produsen data resmi dan walidata Pemerintah Provinsi Aceh.</div>
            </div>
        </div>

        <!-- Section 1: Pemetaan Elemen Metadata -->
        <section class="content-card">
            <div class="section-header">
                <h2 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Tabel Pemetaan Elemen Metadata ke Sistem PetaKita
                </h2>
                <div class="table-search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="metaSearchInput" placeholder="Cari elemen atau tag..." onkeyup="filterMetaTable()">
                </div>
            </div>

            <p style="color:var(--text-secondary);font-size:14px;margin-bottom:18px;">
                Saat operator SKPA mengunggah berkas XML Metadata ke sistem melalui menu <strong>Tambah Dataset</strong>, mesin parser terintegrasi (<code>XmlMetadataParserService</code>) akan mengekstrak otomatis tag-tag ISO 19139 / FGDC berikut ke basis data:
            </p>

            <div class="table-wrapper">
                <table class="meta-table" id="metaTable">
                    <thead>
                        <tr>
                            <th>Elemen Metadata</th>
                            <th>Jalur Tag XML (XPath ISO 19139 / FGDC)</th>
                            <th>Kolom Basis Data</th>
                            <th>Status</th>
                            <th>Keterangan & Nilai Default</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Title (Judul Dataset)</strong></td>
                            <td><span class="tag-badge">//gmd:title/gco:CharacterString</span><br><small style="color:var(--text-muted)">Fallback: //title, //citation/title</small></td>
                            <td><code>datasets.title</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Nama resmi lapisan geospasial (misal: <em>Batas Administrasi Kabupaten/Kota Aceh</em>).</td>
                        </tr>
                        <tr>
                            <td><strong>Abstract (Abstrak)</strong></td>
                            <td><span class="tag-badge">//gmd:abstract/gco:CharacterString</span><br><small style="color:var(--text-muted)">Fallback: //abstract, //descript/abstract</small></td>
                            <td><code>dataset_metadata.abstract</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Ringkasan narasi mengenai muatan isi data spasial, sumber perolehan, dan periode tahun.</td>
                        </tr>
                        <tr>
                            <td><strong>Purpose (Tujuan Penggunaan)</strong></td>
                            <td><span class="tag-badge">//gmd:purpose/gco:CharacterString</span><br><small style="color:var(--text-muted)">Fallback: //purpose, //descript/purpose</small></td>
                            <td><code>dataset_metadata.purpose</code></td>
                            <td><span class="status-badge status-recommended">Dianjurkan</span></td>
                            <td>Maksud pembuatan data (misal: perencanaan tata ruang RTRW, mitigasi kebencanaan BPBA).</td>
                        </tr>
                        <tr>
                            <td><strong>Lineage (Riwayat & Metodologi)</strong></td>
                            <td><span class="tag-badge">//gmd:statement/gco:CharacterString</span><br><small style="color:var(--text-muted)">Fallback: //lineage, //procdesc</small></td>
                            <td><code>dataset_metadata.lineage</code></td>
                            <td><span class="status-badge status-recommended">Dianjurkan</span></td>
                            <td>Riwayat pemrosesan data (digitasi citra satelit, survei lapangan GNSS, konversi SHP).</td>
                        </tr>
                        <tr>
                            <td><strong>Point of Contact (Instansi Produsen)</strong></td>
                            <td><span class="tag-badge">//gmd:organisationName/gco:CharacterString</span><br><small style="color:var(--text-muted)">Fallback: //cntorg, //cntper</small></td>
                            <td><code>dataset_metadata.contact_point</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Nama SKPA produsen data (misal: <em>BAPPEDA Aceh, Dinas PUPR Aceh, DLHK Aceh</em>).</td>
                        </tr>
                        <tr>
                            <td><strong>Bounding Box: West Longitude</strong></td>
                            <td><span class="tag-badge">//gmd:westBoundLongitude/gco:Decimal</span><br><small style="color:var(--text-muted)">Fallback: //westbc</small></td>
                            <td><code>dataset_metadata.bounding_box</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Batas barat koordinat geografis wilayah (Default Aceh: <code>95.00</code>).</td>
                        </tr>
                        <tr>
                            <td><strong>Bounding Box: East Longitude</strong></td>
                            <td><span class="tag-badge">//gmd:eastBoundLongitude/gco:Decimal</span><br><small style="color:var(--text-muted)">Fallback: //eastbc</small></td>
                            <td><code>dataset_metadata.bounding_box</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Batas timur koordinat geografis wilayah (Default Aceh: <code>98.50</code>).</td>
                        </tr>
                        <tr>
                            <td><strong>Bounding Box: South Latitude</strong></td>
                            <td><span class="tag-badge">//gmd:southBoundLatitude/gco:Decimal</span><br><small style="color:var(--text-muted)">Fallback: //southbc</small></td>
                            <td><code>dataset_metadata.bounding_box</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Batas selatan koordinat geografis wilayah (Default Aceh: <code>2.00</code>).</td>
                        </tr>
                        <tr>
                            <td><strong>Bounding Box: North Latitude</strong></td>
                            <td><span class="tag-badge">//gmd:northBoundLatitude/gco:Decimal</span><br><small style="color:var(--text-muted)">Fallback: //northbc</small></td>
                            <td><code>dataset_metadata.bounding_box</code></td>
                            <td><span class="status-badge status-required">Wajib</span></td>
                            <td>Batas utara koordinat geografis wilayah (Default Aceh: <code>6.00</code>).</td>
                        </tr>
                        <tr>
                            <td><strong>Spatial Reference System</strong></td>
                            <td><span class="tag-badge">//gmd:RS_Identifier/gmd:code</span></td>
                            <td><code>dataset_metadata.reference_system</code></td>
                            <td><span class="status-badge status-required">Tetap</span></td>
                            <td>Standar proyeksi geospasial: <code>EPSG:4326 (WGS 84)</code>.</td>
                        </tr>
                        <tr>
                            <td><strong>Spatial Resolution (Skala)</strong></td>
                            <td><span class="tag-badge">//gmd:equivalentScale/gmd:MD_RepresentativeFraction</span></td>
                            <td><code>dataset_metadata.scale_denominator</code></td>
                            <td><span class="status-badge status-recommended">Dianjurkan</span></td>
                            <td>Penyebut skala peta (contoh: <code>25000</code> untuk skala 1:25.000).</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section 2: Contoh Format XML Standar ISO 19139 / JSON -->
        <section class="content-card" id="codePreviewSection">
            <div class="section-header">
                <h2 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    Struktur Kode & Template Metadata Resmi
                </h2>
                <span class="badge-pill">ISO 19139 Schema Ready</span>
            </div>

            <!-- Tab Buttons -->
            <div class="tab-nav">
                <button type="button" class="tab-btn active" onclick="switchTab('xml')">📄 XML SNI ISO 19115 (GMD)</button>
                <button type="button" class="tab-btn" onclick="switchTab('json')">🌐 JSON Schema (REST API v2)</button>
            </div>

            <!-- XML Pane -->
            <div id="tabXmlPane" class="code-container">
                <div class="code-header">
                    <span>template_metadata_sni_iso_19115_aceh.xml</span>
                    <div style="display:flex;gap:8px;">
                        <button type="button" class="btn-copy-code" onclick="copyXmlCode()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            Salin XML
                        </button>
                        <button type="button" class="btn-copy-code" style="background:var(--accent);" onclick="downloadXmlTemplate()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Unduh File .XML
                        </button>
                    </div>
                </div>
                <pre><code id="xmlCodeContent">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;!-- ===================================================================== --&gt;
&lt;!-- TEMPLATE METADATA STANDAR SNI ISO 19115:2012 / ISO 19139               --&gt;
&lt;!-- PORTAL PETAKITA ACEH - PEMERINTAH PROVINSI ACEH                        --&gt;
&lt;!-- ===================================================================== --&gt;
&lt;gmd:MD_Metadata xmlns:gmd="http://www.isotc211.org/2005/gmd"
                 xmlns:gco="http://www.isotc211.org/2005/gco"
                 xmlns:gts="http://www.isotc211.org/2005/gts"
                 xmlns:gml="http://www.opengis.net/gml"
                 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"&gt;

    &lt;!-- 1. IDENTIFIKASI METADATA --&gt;
    &lt;gmd:fileIdentifier&gt;
        &lt;gco:CharacterString&gt;aceh-geo-meta-2026-001&lt;/gco:CharacterString&gt;
    &lt;/gmd:fileIdentifier&gt;
    &lt;gmd:language&gt;
        &lt;gco:CharacterString&gt;ind&lt;/gco:CharacterString&gt;
    &lt;/gmd:language&gt;
    &lt;gmd:dateStamp&gt;
        &lt;gco:Date&gt;2026-10-26&lt;/gco:Date&gt;
    &lt;/gmd:dateStamp&gt;

    &lt;!-- 2. NARAHUBUNG INSTANSI (POINT OF CONTACT) --&gt;
    &lt;gmd:contact&gt;
        &lt;gmd:CI_ResponsibleParty&gt;
            &lt;gmd:organisationName&gt;
                &lt;gco:CharacterString&gt;BAPPEDA Provinsi Aceh&lt;/gco:CharacterString&gt;
            &lt;/gmd:organisationName&gt;
            &lt;gmd:role&gt;
                &lt;gmd:CI_RoleCode codeList="http://standards.iso.org/ittf/PubliclyAvailableStandards/ISO_19139_Schemas/resources/codelist/gmxCodelists.xml#CI_RoleCode" codeListValue="pointOfContact"&gt;pointOfContact&lt;/gmd:CI_RoleCode&gt;
            &lt;/gmd:role&gt;
        &lt;/gmd:CI_ResponsibleParty&gt;
    &lt;/gmd:contact&gt;

    &lt;!-- 3. INFORMASI IDENTIFIKASI DATASET --&gt;
    &lt;gmd:identificationInfo&gt;
        &lt;gmd:MD_DataIdentification&gt;
            &lt;gmd:citation&gt;
                &lt;gmd:CI_Citation&gt;
                    &lt;gmd:title&gt;
                        &lt;gco:CharacterString&gt;Batas Administrasi 23 Kabupaten Kota Provinsi Aceh&lt;/gco:CharacterString&gt;
                    &lt;/gmd:title&gt;
                    &lt;gmd:date&gt;
                        &lt;gmd:CI_Date&gt;
                            &lt;gmd:date&gt;&lt;gco:Date&gt;2026-01-01&lt;/gco:Date&gt;&lt;/gmd:date&gt;
                            &lt;gmd:dateType&gt;&lt;gmd:CI_DateTypeCode codeListValue="publication"/&gt;&lt;/gmd:dateType&gt;
                        &lt;/gmd:CI_Date&gt;
                    &lt;/gmd:date&gt;
                &lt;/gmd:CI_Citation&gt;
            &lt;/gmd:citation&gt;

            &lt;gmd:abstract&gt;
                &lt;gco:CharacterString&gt;Dataset spasial batas administrasi resmi 23 Kabupaten dan Kota di Provinsi Aceh hasil penetapan batas wilayah dengan sistem proyeksi geografis WGS 84.&lt;/gco:CharacterString&gt;
            &lt;/gmd:abstract&gt;

            &lt;gmd:purpose&gt;
                &lt;gco:CharacterString&gt;Rujukan resmi batas wilayah administrasi perencanaan tata ruang dan integrasi Satu Peta Aceh.&lt;/gco:CharacterString&gt;
            &lt;/gmd:purpose&gt;

            &lt;gmd:topicCategory&gt;
                &lt;gmd:MD_TopicCategoryCode&gt;boundaries&lt;/gmd:MD_TopicCategoryCode&gt;
            &lt;/gmd:topicCategory&gt;

            &lt;!-- 4. BOUNDING BOX GEOGRAFIS ACEH (EPSG:4326) --&gt;
            &lt;gmd:extent&gt;
                &lt;gmd:EX_Extent&gt;
                    &lt;gmd:geographicElement&gt;
                        &lt;gmd:EX_GeographicBoundingBox&gt;
                            &lt;gmd:westBoundLongitude&gt;&lt;gco:Decimal&gt;95.00&lt;/gco:Decimal&gt;&lt;/gmd:westBoundLongitude&gt;
                            &lt;gmd:eastBoundLongitude&gt;&lt;gco:Decimal&gt;98.50&lt;/gco:Decimal&gt;&lt;/gmd:eastBoundLongitude&gt;
                            &lt;gmd:southBoundLatitude&gt;&lt;gco:Decimal&gt;2.00&lt;/gco:Decimal&gt;&lt;/gmd:southBoundLatitude&gt;
                            &lt;gmd:northBoundLatitude&gt;&lt;gco:Decimal&gt;6.00&lt;/gco:Decimal&gt;&lt;/gmd:northBoundLatitude&gt;
                        &lt;/gmd:EX_GeographicBoundingBox&gt;
                    &lt;/gmd:geographicElement&gt;
                &lt;/gmd:EX_Extent&gt;
            &lt;/gmd:extent&gt;
        &lt;/gmd:MD_DataIdentification&gt;
    &lt;/gmd:identificationInfo&gt;

    &lt;!-- 5. SILSILAH / METODOLOGI PEROLEHAN DATA --&gt;
    &lt;gmd:dataQualityInfo&gt;
        &lt;gmd:DQ_DataQuality&gt;
            &lt;gmd:lineage&gt;
                &lt;gmd:LI_Lineage&gt;
                    &lt;gmd:statement&gt;
                        &lt;gco:CharacterString&gt;Disusun berdasarkan kompilasi peta penetapan batas wilayah Kemendagri dan validasi lapangan Biro Pemerintahan Setda Aceh.&lt;/gco:CharacterString&gt;
                    &lt;/gmd:statement&gt;
                &lt;/gmd:LI_Lineage&gt;
            &lt;/gmd:lineage&gt;
        &lt;/gmd:DQ_DataQuality&gt;
    &lt;/gmd:dataQualityInfo&gt;

&lt;/gmd:MD_Metadata&gt;</code></pre>
            </div>

            <!-- JSON Pane -->
            <div id="tabJsonPane" class="code-container" style="display:none;">
                <div class="code-header">
                    <span>dataset_metadata_schema.json</span>
                    <button type="button" class="btn-copy-code" onclick="copyJsonCode()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Salin JSON
                    </button>
                </div>
                <pre><code id="jsonCodeContent">{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "PetaKita Aceh Dataset Metadata",
  "standard": "SNI ISO 19115:2012 / Satu Peta Indonesia",
  "properties": {
    "title": "Batas Administrasi 23 Kabupaten Kota Provinsi Aceh",
    "abstract": "Dataset spasial batas administrasi resmi 23 Kabupaten dan Kota di Provinsi Aceh.",
    "purpose": "Rujukan resmi batas wilayah administrasi dan integrasi Satu Peta Aceh.",
    "lineage": "Kompilasi batas penetapan Kemendagri dan validasi lapangan Biro Pemerintahan Setda Aceh.",
    "spatial_representation_type": "vector",
    "reference_system": "EPSG:4326 (WGS 84)",
    "scale_denominator": 25000,
    "bounding_box": {
      "west": 95.00,
      "east": 98.50,
      "south": 2.00,
      "north": 6.00
    },
    "contact_point": "BAPPEDA Provinsi Aceh"
  }
}</code></pre>
            </div>
        </section>

        <!-- Section 3: Interactive XML Metadata Validator Playground -->
        <section class="content-card" id="validatorSection">
            <div class="section-header">
                <h2 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    Uji Validasi Metadata XML (Client-Side Inspector)
                </h2>
                <span class="badge-pill">Simulasi Parser Laravel</span>
            </div>

            <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">
                Tempelkan teks berkas XML metadata Anda di bawah ini untuk memeriksa apakah tag-tag penting SNI ISO 19115 sudah lengkap dan dapat dibaca oleh sistem PetaKita sebelum diunggah ke panel admin:
            </p>

            <div class="validator-box">
                <textarea id="validatorInput" class="validator-textarea" placeholder="Tempelkan kode XML metadata di sini... (atau klik tombol 'Muat Contoh XML' di bawah)"></textarea>
                
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <button type="button" class="btn-hero btn-hero-primary" style="background:var(--accent);color:#ffffff;" onclick="runXmlValidation()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        Periksa Validitas XML
                    </button>
                    <button type="button" class="btn-hero btn-hero-secondary" style="background:#e2e8f0;color:var(--text-primary);border:1px solid #cbd5e1;" onclick="loadSampleToValidator()">
                        Muat Contoh XML Aceh
                    </button>
                    <button type="button" class="btn-hero btn-hero-secondary" style="background:#ffffff;color:var(--text-secondary);border:1px solid #cbd5e1;" onclick="clearValidator()">
                        Bersihkan
                    </button>
                </div>

                <!-- Validation Result Panel -->
                <div id="validatorResultPanel" class="validator-results">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <h4 style="font-size:15px;color:var(--text-primary);font-weight:700;">Hasil Pengujian Metadata:</h4>
                        <span id="validationOverallStatus" class="status-badge status-required">Memeriksa...</span>
                    </div>

                    <div id="validationItemContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4: Alur Kerja Operator SKPA -->
        <section class="content-card">
            <div class="section-header">
                <h2 class="section-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    Alur Standarisasi bagi Operator Dinas & SKPA
                </h2>
                <span class="badge-pill">SOP Satu Peta Aceh</span>
            </div>

            <div class="workflow-grid">
                <div class="workflow-step">
                    <div class="step-num">1</div>
                    <div class="step-title">Siapkan Data & XML</div>
                    <div class="step-desc">Ekspor file spasial (GeoJSON/SHP) dengan koordinat EPSG:4326 dan siapkan berkas XML ISO 19115 menggunakan template resmi.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">2</div>
                    <div class="step-title">Login ke Portal SKPA</div>
                    <div class="step-desc">Masuk ke panel administrasi Filament <code>/admin</code> dengan kredensial akun instansi dinas masing-masing.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">3</div>
                    <div class="step-title">Unggah File Metadata</div>
                    <div class="step-desc">Pada form pembuatan dataset, unggah berkas XML. Sistem mengekstrak judul, abstrak, dan batas BBOX secara otomatis.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">4</div>
                    <div class="step-title">Tinjauan & Publikasi</div>
                    <div class="step-desc">Status tersimpan sebagai <code>pending_review</code> untuk diverifikasi oleh Super Admin BAPPEDA sebelum tayang ke publik.</div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="nav-logo-icon">🗺️</div>
                    <div>
                        <div class="nav-logo-text">PetaKita <span>Aceh</span></div>
                        <div style="font-size:12px;color:var(--text-muted)">Portal Data Geospasial Terpadu Pemerintah Provinsi Aceh</div>
                    </div>
                </div>
                <div style="display:flex;gap:16px;flex-wrap:wrap;font-size:13.5px;">
                    <a href="/" style="color:var(--text-secondary);text-decoration:none;">Beranda</a>
                    <a href="/katalog" style="color:var(--text-secondary);text-decoration:none;">Katalog Data</a>
                    <a href="/map" style="color:var(--text-secondary);text-decoration:none;">WebGIS</a>
                    <a href="/dokumentasi-api" style="color:var(--text-secondary);text-decoration:none;">REST API</a>
                    <a href="/standar-metadata" style="color:var(--accent);font-weight:600;text-decoration:none;">Standar Metadata</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div>
                    © 2026 <strong>PetaKita Aceh</strong> — Dikembangkan untuk Kebijakan Satu Peta Provinsi Aceh.
                </div>
                <div>
                    Kepatuhan Standar: <span style="color:var(--accent);font-weight:600;">SNI ISO 19115:2012 / BIG RI</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Interactions -->
    <script>
        // Tab switching
        function switchTab(type) {
            const xmlPane = document.getElementById('tabXmlPane');
            const jsonPane = document.getElementById('tabJsonPane');
            const buttons = document.querySelectorAll('.tab-btn');

            if (type === 'xml') {
                xmlPane.style.display = 'block';
                jsonPane.style.display = 'none';
                buttons[0].classList.add('active');
                buttons[1].classList.remove('active');
            } else {
                xmlPane.style.display = 'none';
                jsonPane.style.display = 'block';
                buttons[0].classList.remove('active');
                buttons[1].classList.add('active');
            }
        }

        // Copy XML
        function copyXmlCode() {
            const code = document.getElementById('xmlCodeContent').innerText;
            navigator.clipboard.writeText(code).then(() => {
                showToast('Kode XML Metadata SNI ISO 19115 berhasil disalin!');
            });
        }

        // Copy JSON
        function copyJsonCode() {
            const code = document.getElementById('jsonCodeContent').innerText;
            navigator.clipboard.writeText(code).then(() => {
                showToast('Skema JSON Metadata berhasil disalin!');
            });
        }

        // Download Template XML
        function downloadXmlTemplate() {
            const xmlContent = document.getElementById('xmlCodeContent').innerText;
            const blob = new Blob([xmlContent], { type: 'application/xml' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'template_metadata_sni_iso_19115_aceh.xml';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('Berkas template XML berhasil diunduh!');
        }

        // Toast feedback
        function showToast(msg) {
            const toast = document.getElementById('toastNotif');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.innerText = msg;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3200);
        }

        // Filter Metadata Table
        function filterMetaTable() {
            const query = document.getElementById('metaSearchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#metaTable tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }

        // Load sample to validator
        function loadSampleToValidator() {
            const sample = document.getElementById('xmlCodeContent').innerText;
            document.getElementById('validatorInput').value = sample;
            showToast('Contoh XML dimuat ke kotak validator.');
        }

        function clearValidator() {
            document.getElementById('validatorInput').value = '';
            document.getElementById('validatorResultPanel').style.display = 'none';
        }

        // Run Client-Side XML Validation
        function runXmlValidation() {
            const rawXml = document.getElementById('validatorInput').value.trim();
            const panel = document.getElementById('validatorResultPanel');
            const container = document.getElementById('validationItemContainer');
            const statusBadge = document.getElementById('validationOverallStatus');

            if (!rawXml) {
                alert('Silakan tempelkan kode XML terlebih dahulu atau klik "Muat Contoh XML Aceh".');
                return;
            }

            panel.style.display = 'block';
            container.innerHTML = '';

            try {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(rawXml, "application/xml");

                // Check parsererror
                const parseError = xmlDoc.getElementsByTagName("parsererror");
                if (parseError.length > 0) {
                    statusBadge.className = 'status-badge status-required';
                    statusBadge.innerText = 'XML Tidak Valid (Syntax Error)';
                    container.innerHTML = `
                        <div style="color:#b91c1c;font-size:13px;padding:8px 0;">
                            Format XML mengalami kesalahan sintaks: ${parseError[0].textContent.substring(0, 150)}...
                        </div>
                    `;
                    return;
                }

                // Helper to search tag text
                function findValue(tagNames) {
                    for (const tag of tagNames) {
                        const els = xmlDoc.getElementsByTagName(tag);
                        if (els.length > 0 && els[0].textContent.trim().length > 0) {
                            return els[0].textContent.trim();
                        }
                    }
                    return null;
                }

                const checks = [
                    { name: 'Judul Dataset (Title)', value: findValue(['gmd:title', 'title']), required: true },
                    { name: 'Abstrak (Abstract)', value: findValue(['gmd:abstract', 'abstract']), required: true },
                    { name: 'Tujuan (Purpose)', value: findValue(['gmd:purpose', 'purpose']), required: false },
                    { name: 'Silsilah (Lineage)', value: findValue(['gmd:statement', 'lineage']), required: false },
                    { name: 'Instansi (Point of Contact)', value: findValue(['gmd:organisationName', 'cntorg']), required: true },
                    { name: 'Batas Barat (West BBOX)', value: findValue(['gmd:westBoundLongitude', 'westbc']), required: true },
                    { name: 'Batas Timur (East BBOX)', value: findValue(['gmd:eastBoundLongitude', 'eastbc']), required: true },
                    { name: 'Batas Selatan (South BBOX)', value: findValue(['gmd:southBoundLatitude', 'southbc']), required: true },
                    { name: 'Batas Utara (North BBOX)', value: findValue(['gmd:northBoundLatitude', 'northbc']), required: true }
                ];

                let allRequiredOk = true;

                checks.forEach(item => {
                    const ok = item.value !== null && item.value.length > 0;
                    if (item.required && !ok) {
                        allRequiredOk = false;
                    }

                    const row = document.createElement('div');
                    row.className = 'result-item';
                    row.innerHTML = `
                        <div>
                            <strong>${item.name}</strong> 
                            ${item.required ? '<span style="color:#b91c1c">*</span>' : '<span style="color:#64748b;font-size:11px;">(opsional)</span>'}
                            <div style="font-size:12px;color:#64748b;font-family:var(--font-mono);margin-top:2px;">
                                ${ok ? item.value : '<em style="color:#ef4444">Tidak ditemukan</em>'}
                            </div>
                        </div>
                        <div>
                            <span class="status-badge ${ok ? 'status-recommended' : (item.required ? 'status-required' : 'status-recommended')}" style="${ok ? 'background:#dcfce7;color:#15803d;' : ''}">
                                ${ok ? '✓ Terdeteksi' : (item.required ? '✗ Hilang' : '— Kosong')}
                            </span>
                        </div>
                    `;
                    container.appendChild(row);
                });

                if (allRequiredOk) {
                    statusBadge.className = 'status-badge';
                    statusBadge.style.cssText = 'background:#dcfce7;color:#15803d;font-weight:700;';
                    statusBadge.innerText = '✓ Siap Diunggah ke PetaKita';
                } else {
                    statusBadge.className = 'status-badge status-required';
                    statusBadge.innerText = 'Elemen Wajib Belum Lengkap';
                }

            } catch (err) {
                statusBadge.className = 'status-badge status-required';
                statusBadge.innerText = 'Gagal Mengurai';
                container.innerHTML = `<div style="color:#b91c1c;font-size:13px;">Error: ${err.message}</div>`;
            }
        }
    </script>
</body>
</html>
