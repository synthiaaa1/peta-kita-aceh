<?php

namespace App\Filament\Resources\Datasets;

use App\Filament\Resources\Datasets\Pages\CreateDataset;
use App\Filament\Resources\Datasets\Pages\EditDataset;
use App\Filament\Resources\Datasets\Pages\ListDatasets;
use App\Filament\Resources\Datasets\Schemas\DatasetForm;
use App\Filament\Resources\Datasets\Tables\DatasetsTable;
use App\Models\Dataset;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Dataset Spasial';
    protected static ?string $pluralModelLabel = 'Dataset Spasial';
    protected static string|\UnitEnum|null $navigationGroup = 'Katalog Geospasial';

    public static function form(Schema $schema): Schema
    {
        return DatasetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DatasetsTable::configure($table);
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
            $query->where('agency_id', $user->agency_id);
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
            'index' => ListDatasets::route('/'),
            'create' => CreateDataset::route('/create'),
            'edit' => EditDataset::route('/{record}/edit'),
        ];
    }
}
