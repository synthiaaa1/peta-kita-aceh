<?php

namespace App\Filament\Widgets;

use App\Models\DatasetDownload;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class DownloadsChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Unduhan (30 Hari Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $user = auth()->user();
        $query = DatasetDownload::query()
            ->where('created_at', '>=', now()->subDays(30));

        if ($user && $user->isOperator() && $user->agency_id) {
            $query->whereHas('dataset', function ($q) use ($user) {
                $q->where('agency_id', $user->agency_id);
            });
        }

        $downloads = $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = [];
        $labels = [];

        // Fill empty days
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->translatedFormat('d M');
            $data[] = $downloads->firstWhere('date', $date)?->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Unduhan',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
