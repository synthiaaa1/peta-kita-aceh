<?php

namespace App\Filament\Resources\Layers\Pages;

use App\Filament\Resources\Layers\LayerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Services\Spatial\GeoConversionService;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class EditLayer extends EditRecord
{
    protected static string $resource = LayerResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        if ($user && $user->isAdmin()) {
            return [
                Actions\DeleteAction::make(),
            ];
        }

        return [];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getRawState();
        $fileKey = $data['spatial_file'] ?? ($data['geojson_file'] ?? null);

        if (!empty($fileKey)) {
            $filePath = is_array($fileKey) ? array_values($fileKey)[0] : $fileKey;
            $fullPath = Storage::disk('local')->path($filePath);
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            if (in_array($extension, ['zip', 'shp', 'shx', 'dbf'])) {
                $shpService = app(\App\Services\Spatial\ShapefileParserService::class);
                $result = $shpService->importShapefileBundle($this->record, $fullPath);
            } else {
                $content = Storage::disk('local')->get($filePath);
                $geoService = app(GeoConversionService::class);
                $result = $geoService->importGeoJson($this->record, $content);
            }

            if ($result['success']) {
                Notification::make()->title('Data Spasial Berhasil Diproses (' . ($result['count'] ?? 0) . ' Fitur)')->success()->send();
            } else {
                Notification::make()->title('Gagal Memproses Data Spasial')->body($result['message'])->danger()->send();
            }

            Storage::disk('local')->delete($filePath);
        }
    }
}
