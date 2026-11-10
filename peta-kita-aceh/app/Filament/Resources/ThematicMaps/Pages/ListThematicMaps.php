<?php

namespace App\Filament\Resources\ThematicMaps\Pages;

use App\Filament\Resources\ThematicMaps\ThematicMapResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThematicMaps extends ListRecords
{
    protected static string $resource = ThematicMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
