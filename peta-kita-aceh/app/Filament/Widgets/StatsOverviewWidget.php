<?php

namespace App\Filament\Widgets;

use App\Models\Agency;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();
        $isAdmin = $user?->isAdmin();

        if ($isAdmin) {
            return [
                Stat::make('Dataset Tayang (Publik)', Dataset::where('status', 'published')->count())
                    ->description('Dataset disetujui')
                    ->descriptionIcon('heroicon-m-check-badge')
                    ->color('success'),
                Stat::make('Menunggu Tinjauan Admin', Dataset::where('status', 'pending_review')->count())
                    ->description('Membutuhkan persetujuan')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),
                Stat::make('Instansi / SKPA', Agency::count())
                    ->description('Total OPD Aceh terdaftar')
                    ->descriptionIcon('heroicon-m-building-office')
                    ->color('info'),
                Stat::make('Total Pengguna', User::count())
                    ->description('Admin & Operator Dinas')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary'),
            ];
        } else {
            $agencyId = $user?->agency_id;
            $agencyName = $user?->agency?->name ?? 'Dinas';

            return [
                Stat::make('Dataset Instansi Saya', Dataset::where('agency_id', $agencyId)->count())
                    ->description($agencyName)
                    ->descriptionIcon('heroicon-m-circle-stack')
                    ->color('info'),
                Stat::make('Menunggu Persetujuan Admin', Dataset::where('agency_id', $agencyId)->where('status', 'pending_review')->count())
                    ->description('Sedang ditinjau oleh Admin')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),
                Stat::make('Disetujui & Tayang', Dataset::where('agency_id', $agencyId)->where('status', 'published')->count())
                    ->description('Sudah tampil di geoportal publik')
                    ->descriptionIcon('heroicon-m-check-badge')
                    ->color('success'),
                Stat::make('Layer Spasial Saya', Layer::whereHas('dataset', fn($q) => $q->where('agency_id', $agencyId))->count())
                    ->description('Layer data peta')
                    ->descriptionIcon('heroicon-m-map')
                    ->color('primary'),
            ];
        }
    }
}
