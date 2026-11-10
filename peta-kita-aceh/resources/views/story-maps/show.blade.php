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
