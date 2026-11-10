<?php

namespace App\Filament\Widgets;

use App\Models\Dataset;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopDatasetsTable extends BaseWidget
{
    protected static ?string $heading = 'Top 10 Dataset Paling Banyak Diunduh';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        $query = Dataset::query()->withCount('downloads')->orderByDesc('downloads_count')->limit(10);
        $user = auth()->user();

        if ($user && $user->isOperator() && $user->agency_id) {
            $query->where('agency_id', $user->agency_id);
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dataset')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('agency.name')
                    ->label('Instansi / OPD')
                    ->visible(fn () => $user && $user->isAdmin()),
                Tables\Columns\TextColumn::make('downloads_count')
                    ->label('Total Unduhan')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
