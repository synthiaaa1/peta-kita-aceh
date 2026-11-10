<?php

namespace App\Filament\Resources\Datasets\Pages;

use App\Filament\Resources\Datasets\DatasetResource;
use Filament\Resources\Pages\CreateRecord;

use App\Services\Spatial\XmlMetadataParserService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class CreateDataset extends CreateRecord
{
    protected static string $resource = DatasetResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getRawState();
        if (!empty($data['xml_metadata_file'])) {
            $filePath = is_array($data['xml_metadata_file']) ? array_values($data['xml_metadata_file'])[0] : $data['xml_metadata_file'];
            $content = Storage::disk('local')->get($filePath);

            $xmlService = app(XmlMetadataParserService::class);
            $result = $xmlService->importXmlMetadata($this->record, $content);

            if ($result['success']) {
                Notification::make()->title('Metadata XML ISO 19115 Berhasil Diproses')->success()->send();
            } else {
                Notification::make()->title('Gagal Memproses XML Metadata')->body($result['message'])->danger()->send();
            }

            Storage::disk('local')->delete($filePath);
        }
    }
}
