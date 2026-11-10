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
