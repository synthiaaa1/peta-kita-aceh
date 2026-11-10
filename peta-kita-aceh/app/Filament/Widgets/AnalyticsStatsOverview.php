<?php

namespace App\Filament\Widgets;

use App\Models\Dataset;
use App\Models\DatasetDownload;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalyticsStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        
        $baseQuery = DatasetDownload::query();
        $datasetQuery = Dataset::query();

        // RBAC: If operator, only show stats for their agency
        if ($user && $user->isOperator() && $user->agency_id) {
            $baseQuery->whereHas('dataset', function ($q) use ($user) {
                $q->where('agency_id', $user->agency_id);
            });
            $datasetQuery->where('agency_id', $user->agency_id);
        }

        $totalDownloads = (clone $baseQuery)->count();
        $downloadsToday = (clone $baseQuery)->whereDate('created_at', today())->count();
        $downloadsThisMonth = (clone $baseQuery)->whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)->count();
        $uniqueDownloaders = (clone $baseQuery)->distinct('ip_address')->count('ip_address');

        return [
            Stat::make('Total Unduhan', number_format($totalDownloads))
                ->description('Semua waktu')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Unduhan Hari Ini', number_format($downloadsToday))
                ->description('Dalam 24 jam terakhir')
                ->color('primary'),
            Stat::make('Unduhan Bulan Ini', number_format($downloadsThisMonth))
                ->description(now()->translatedFormat('F Y'))
                ->color('info'),
            Stat::make('Pengunduh Unik', number_format($uniqueDownloaders))
                ->description('Berdasarkan IP Address')
                ->color('warning'),
        ];
    }
}
