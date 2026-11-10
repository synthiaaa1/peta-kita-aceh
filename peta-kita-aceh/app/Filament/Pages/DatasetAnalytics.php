<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\AnalyticsStatsOverview;
use App\Filament\Widgets\DownloadsChart;
use App\Filament\Widgets\TopDatasetsTable;
use App\Filament\Widgets\TopAgenciesTable;

class DatasetAnalytics extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Analytics';
    protected static ?string $title = 'Dataset Analytics';
    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.dataset-analytics';

    protected function getHeaderWidgets(): array
    {
        return [
            AnalyticsStatsOverview::class,
            DownloadsChart::class,
            TopDatasetsTable::class,
            TopAgenciesTable::class,
        ];
    }
}
