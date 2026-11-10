<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DatasetDownload;
use Illuminate\Support\Facades\DB;

class TopDownloadedDatasetsChart extends ChartWidget
{
    protected ?string $heading = '5 Dataset Paling Sering Diunduh';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Ambil data download, di-group berdasarkan dataset_id
        $downloads = DatasetDownload::select('dataset_id', DB::raw('count(*) as total'))
            ->groupBy('dataset_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('dataset:id,title')
            ->get();

        $labels = [];
        $data = [];

        foreach ($downloads as $download) {
            // Ambil 30 karakter pertama untuk label
            $title = $download->dataset ? \Illuminate\Support\Str::limit($download->dataset->title, 30) : 'Dataset Tidak Dikenal';
            $labels[] = $title;
            $data[] = $download->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Unduhan (Kali)',
                    'data' => $data,
                    'backgroundColor' => '#10b981', // warna hijau emerald
                    'borderColor' => '#047857',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        // Hanya Admin yang bisa melihat grafik ini secara utuh (karena mencakup data lintas instansi)
        return auth()->user()?->isAdmin() ?? false;
    }
}
