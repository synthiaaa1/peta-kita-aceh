<?php

namespace App\Filament\Resources\ThematicMaps;

use App\Filament\Resources\ThematicMaps\Pages\CreateThematicMap;
use App\Filament\Resources\ThematicMaps\Pages\EditThematicMap;
use App\Filament\Resources\ThematicMaps\Pages\ListThematicMaps;
use App\Filament\Resources\ThematicMaps\Schemas\ThematicMapForm;
use App\Filament\Resources\ThematicMaps\Tables\ThematicMapsTable;
use App\Models\ThematicMap;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThematicMapResource extends Resource
{
    protected static ?string $model = ThematicMap::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ThematicMapForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThematicMapsTable::configure($table);
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
            'index' => ListThematicMaps::route('/'),
            'create' => CreateThematicMap::route('/create'),
            'edit' => EditThematicMap::route('/{record}/edit'),
        ];
    }
}
