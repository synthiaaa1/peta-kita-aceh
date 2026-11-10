<?php

namespace App\Filament\Widgets;

use App\Models\Agency;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopAgenciesTable extends BaseWidget
{
    protected static ?string $heading = 'Top 10 OPD dengan Unduhan Terbanyak';
    protected static ?int $sort = 4;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Agency::query()
                    ->withCount(['datasets as total_downloads' => function ($query) {
                        $query->join('dataset_downloads', 'datasets.id', '=', 'dataset_downloads.dataset_id')
                              ->select(\DB::raw('count(dataset_downloads.id)'));
                    }])
                    ->orderByDesc('total_downloads')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama OPD / Instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_downloads')
                    ->label('Total Unduhan')
                    ->sortable()
                    ->badge()
                    ->color('info'),
            ])
            ->paginated(false);
    }
}
