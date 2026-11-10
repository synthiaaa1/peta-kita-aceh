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
Route::get('/katalog/{slug}/metadata-xml', [\App\Http\Controllers\CatalogController::class, 'exportXml'])->name('katalog.metadata.xml');
Route::get('/katalog/{slug}', [\App\Http\Controllers\CatalogController::class, 'show'])->name('katalog.show');

Route::get('/story-maps', [\App\Http\Controllers\StoryMapController::class, 'index'])->name('story-maps.index');
Route::get('/story-maps/{slug}', [\App\Http\Controllers\StoryMapController::class, 'show'])->name('story-maps.show');

Route::get('/tematik', [ThematicMapController::class, 'index'])->name('tematik.index');

Route::get('/dokumentasi-api', [\App\Http\Controllers\ApiDocumentationController::class, 'index']);

Route::get('/standar-metadata', function () {
    return view('docs-metadata');
});

Route::get('/datasets', function () {
    return view('datasets.index');
})->name('datasets.index');

// Group Route 5 Sektor Utama
Route::prefix('sektor')->name('sektor.')->group(function () {
    Route::get('/kebencanaan', fn () => view('sektor.kebencanaan.index'))->name('kebencanaan');
    Route::get('/kependudukan', fn () => view('sektor.kependudukan.index'))->name('kependudukan');
    Route::get('/pertanian', fn () => view('sektor.pertanian.index'))->name('pertanian');
    Route::get('/perikanan', fn () => view('sektor.perikanan.index'))->name('perikanan');
    Route::get('/perkebunan', fn () => view('sektor.perkebunan.index'))->name('perkebunan');
});

// Shortcut URL langsung (/kebencanaan, /perikanan, dst.)
Route::get('/kebencanaan', fn () => redirect('/sektor/kebencanaan'));
Route::get('/kependudukan', fn () => redirect('/sektor/kependudukan'));
Route::get('/pertanian', fn () => redirect('/sektor/pertanian'));
Route::get('/perikanan', fn () => redirect('/sektor/perikanan'));
Route::get('/perkebunan', fn () => redirect('/sektor/perkebunan'));
