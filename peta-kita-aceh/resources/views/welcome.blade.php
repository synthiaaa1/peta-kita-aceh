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

        /* Dropdown Dataset */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .nav-dropdown-btn {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
            transition: color 0.2s, background 0.2s;
        }

        .nav-dropdown-btn:hover,
        .nav-dropdown:hover .nav-dropdown-btn {
            color: var(--text-primary);
            background: var(--accent-muted);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 180px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 6px;
            display: none;
            z-index: 10000;
            list-style: none;
        }

        .nav-dropdown:hover .nav-dropdown-menu {
            display: block;
        }

        .nav-dropdown-item {
            display: flex !important;
            align-items: center;
            gap: 8px;
            padding: 8px 12px !important;
            border-radius: 8px;
            color: var(--text-primary) !important;
            text-decoration: none;
            font-size: 13px !important;
            font-weight: 600 !important;
            transition: background 0.15s, color 0.15s;
        }

        .nav-dropdown-item:hover {
            background: var(--accent-light) !important;
            color: var(--accent) !important;
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

            <!-- Dropdown Menu Layanan (Pilihan: 5 Sektor) -->
            <li class="nav-dropdown">
                <button type="button" class="nav-dropdown-btn">
                    <span>Layanan</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <ul class="nav-dropdown-menu">
                    <li>
                        <a href="{{ url('/sektor/kebencanaan') }}" class="nav-dropdown-item">
                            <span>🚨</span>
                            <span>Kebencanaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/sektor/kependudukan') }}" class="nav-dropdown-item">
                            <span>👥</span>
                            <span>Kependudukan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/sektor/pertanian') }}" class="nav-dropdown-item">
                            <span>🌾</span>
                            <span>Pertanian</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/sektor/perikanan') }}" class="nav-dropdown-item">
                            <span>🐟</span>
                            <span>Perikanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/sektor/perkebunan') }}" class="nav-dropdown-item">
                            <span>☕</span>
                            <span>Perkebunan</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown Menu Dataset (Pilihan: Mapset & Dataset) -->
            <li class="nav-dropdown">
                <button type="button" class="nav-dropdown-btn">
                    <span>Dataset</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <ul class="nav-dropdown-menu">
                    <li>
                        <a href="{{ url('/map?q=&layers=3%2C3&lat=5.09094&lng=96.34735&z=9') }}" class="nav-dropdown-item">
                            <span>🗺️</span>
                            <span>Mapset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/datasets') }}" class="nav-dropdown-item">
                            <span>📊</span>
                            <span>Dataset</span>
                        </a>
                    </li>
                </ul>
            </li>

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
                        <li><a href="/map">WebGIS Viewer</a></li>
                        <li><a href="{{ url('/katalog') }}">Katalog Dataset</a></li>
                        <li><a href="{{ url('/story-maps') }}">Story Maps</a></li>
                        <li><a href="/dokumentasi-api">API Publik</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Tentang</div>
                    <ul class="footer-links">
                        <li><a href="/#about">Tentang Portal</a></li>
                        <li><a href="/katalog">Instansi Penyedia</a></li>
                        <li><a href="/standar-metadata">Kebijakan Data</a></li>
                        <li><a href="/standar-metadata">Standar Metadata</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Dukungan</div>
                    <ul class="footer-links">
                        <li><a href="/#features">Panduan Penggunaan</a></li>
                        <li><a href="/dokumentasi-api">Dokumentasi API</a></li>
                        <li><a href="mailto:bappeda@acehprov.go.id">Laporkan Masalah</a></li>
                        <li><a href="mailto:bappeda@acehprov.go.id">Kontak</a></li>
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
