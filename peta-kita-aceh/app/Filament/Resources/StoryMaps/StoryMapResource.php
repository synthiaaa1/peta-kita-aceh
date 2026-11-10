<?php

namespace App\Filament\Resources\StoryMaps;

use App\Filament\Resources\StoryMaps\Pages\CreateStoryMap;
use App\Filament\Resources\StoryMaps\Pages\EditStoryMap;
use App\Filament\Resources\StoryMaps\Pages\ListStoryMaps;
use App\Filament\Resources\StoryMaps\Schemas\StoryMapForm;
use App\Filament\Resources\StoryMaps\Tables\StoryMapsTable;
use App\Models\StoryMap;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StoryMapResource extends Resource
{
    protected static ?string $model = StoryMap::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return StoryMapForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StoryMapsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStoryMaps::route('/'),
            'create' => CreateStoryMap::route('/create'),
            'edit' => EditStoryMap::route('/{record}/edit'),
        ];
    }
}
