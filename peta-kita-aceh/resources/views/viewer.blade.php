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