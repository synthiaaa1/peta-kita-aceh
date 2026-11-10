<?php

namespace App\Filament\Resources\ThematicMaps\Pages;

use App\Filament\Resources\ThematicMaps\ThematicMapResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditThematicMap extends EditRecord
{
    protected static string $resource = ThematicMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
