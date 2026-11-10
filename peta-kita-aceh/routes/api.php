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
