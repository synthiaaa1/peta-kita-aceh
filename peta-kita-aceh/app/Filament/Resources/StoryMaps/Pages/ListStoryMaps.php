<?php

namespace App\Filament\Resources\StoryMaps\Pages;

use App\Filament\Resources\StoryMaps\StoryMapResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStoryMaps extends ListRecords
{
    protected static string $resource = StoryMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
