<?php

namespace App\Filament\Resources\Layers;

use App\Filament\Resources\Layers\Pages\CreateLayer;
use App\Filament\Resources\Layers\Pages\EditLayer;
use App\Filament\Resources\Layers\Pages\ListLayers;
use App\Filament\Resources\Layers\Schemas\LayerForm;
use App\Filament\Resources\Layers\Tables\LayersTable;
use App\Models\Layer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LayerResource extends Resource
{
    protected static ?string $model = Layer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Layer Peta';
    protected static ?string $pluralModelLabel = 'Layer Peta';
    protected static string|\UnitEnum|null $navigationGroup = 'Katalog Geospasial';

    public static function form(Schema $schema): Schema
    {
        return LayerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isOperator() && $user->agency_id) {
            $query->whereHas('dataset', fn ($q) => $q->where('agency_id', $user->agency_id));
        }

        return $query;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLayers::route('/'),
            'create' => CreateLayer::route('/create'),
            'edit' => EditLayer::route('/{record}/edit'),
        ];
    }
}
