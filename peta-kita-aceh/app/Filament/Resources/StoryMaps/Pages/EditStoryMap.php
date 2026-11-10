<?php

namespace App\Filament\Resources\StoryMaps\Pages;

use App\Filament\Resources\StoryMaps\StoryMapResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStoryMap extends EditRecord
{
    protected static string $resource = StoryMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
