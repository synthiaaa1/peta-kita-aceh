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
