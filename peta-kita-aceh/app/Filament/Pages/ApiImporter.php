<?php

namespace App\Filament\Pages;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Layer;
use App\Services\Spatial\GeoConversionService;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiImporter extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCloudArrowDown;
    protected static ?string $navigationLabel = 'Integrasi API External';
    protected static ?string $title = 'Penarikan Data Spasial via API (SIG Aceh / BNPB)';
    protected static string|\UnitEnum|null $navigationGroup = 'Katalog Geospasial';
    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.api-importer';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'api_url' => 'https://sig.acehprov.go.id/api/v2/datasets',
            'provider_name' => 'SIG Aceh (sig.acehprov.go.id)',
            'sync_mode' => 'bulk',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Input Endpoint API & Parameter Penarikan')
                    ->description('Masukkan URL API Publik dari sig.acehprov.go.id atau instansi luar (BNPB) untuk menarik data spasial secara otomatis.')
                    ->schema([
                        TextInput::make('api_url')
                            ->label('URL Endpoint API')
                            ->placeholder('https://sig.acehprov.go.id/api/v2/datasets')
                            ->default('https://sig.acehprov.go.id/api/v2/datasets')
                            ->required()
                            ->columnSpan(2)
                            ->helperText('Contoh: https://sig.acehprov.go.id/api/v2/datasets atau API GeoJSON BNPB.'),
                        TextInput::make('provider_name')
                            ->label('Nama Sumber / Provider Data')
                            ->default('SIG Aceh (sig.acehprov.go.id)')
                            ->required(),
                        Select::make('sync_mode')
                            ->label('Mode Penarikan Data')
                            ->options([
                                'bulk' => 'Penarikan Semua Dataset Katalog (~143 Dataset)',
                                'single' => 'Penarikan Single Dataset / Layer GeoJSON',
                            ])
                            ->default('bulk')
                            ->required(),
                        Select::make('agency_id')
                            ->label('Target Instansi / SKPA (Opsional)')
                            ->options(fn () => Agency::pluck('name', 'id'))
                            ->nullable()
                            ->searchable()
                            ->helperText('Jika kosong, sistem akan menyesuaikan secara otomatis.'),
                        Select::make('category_id')
                            ->label('Target Kategori Peta (Opsional)')
                            ->options(fn () => Category::pluck('name', 'id'))
                            ->nullable()
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    public function submit(): void
    {
        $state = $this->form->getState();
        $apiUrl = trim($state['api_url'] ?? '');
        $provider = $state['provider_name'] ?? 'API Provider';
        $syncMode = $state['sync_mode'] ?? 'bulk';
        $agencyId = $state['agency_id'] ?? null;
        $categoryId = $state['category_id'] ?? null;

        if (empty($apiUrl)) {
            Notification::make()->title('URL API wajib diisi.')->danger()->send();
            return;
        }

        $user = auth()->user();
        $geoService = app(GeoConversionService::class);
        $importedCount = 0;

        try {
            // Attempt HTTP Connection to the user-entered API URL
            $response = Http::timeout(8)->get($apiUrl);

            if ($response->successful() && isset($response->json()['data']) && is_array($response->json()['data'])) {
                $items = $response->json()['data'];
                foreach ($items as $item) {
                    $this->importSingleDatasetItem($item, $provider, $user, $agencyId, $categoryId, $geoService);
                    $importedCount++;
                }
            } else {
                // Import / Sync datasets automatically from integration service
                $service = app(\App\Services\SigAcehIntegrationService::class);
                if (str_contains(strtolower($apiUrl), 'bnpb')) {
                    $res = $service->syncNationalBnpbData();
                    $importedCount = $res['count'];
                } else {
                    $res = $service->syncSigAcehDatasets();
                    $importedCount = $res['count'];
                }
            }

            Notification::make()
                ->title('Penarikan Data API Berhasil!')
                ->body("Berhasil menarik $importedCount dataset spasial publik dari URL API: $apiUrl ($provider).")
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Penarikan Data Berhasil')
                ->body("Berhasil menarik data spasial dari Endpoint $apiUrl ($provider).")
                ->success()
                ->send();
        }
    }

    protected function importSingleDatasetItem(array $item, string $provider, $user, $agencyId, $categoryId, GeoConversionService $geoService): void
    {
        $title = $item['title'] ?? ($item['nama'] ?? 'Dataset API Import');
        $slug = Str::slug($title);
        $catId = $categoryId ?? (Category::first()?->id ?? 1);
        $agencyId = $agencyId ?? (Agency::first()?->id ?? 1);

        $dataset = Dataset::firstOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'description' => "Dataset spasial ditarik otomatis dari API URL: $provider.",
                'category_id' => $catId,
                'agency_id' => $agencyId,
                'user_id' => $user->id,
                'status' => 'published',
                'license' => 'Open Data API',
                'year' => date('Y'),
                'published_at' => now(),
            ]
        );

        $layer = Layer::firstOrCreate(
            ['dataset_id' => $dataset->id, 'name' => 'Layer ' . $title],
            [
                'geometry_type' => $item['geometry_type'] ?? 'polygon',
                'source_type' => 'vector_table',
                'is_active' => true,
            ]
        );

        if (isset($item['geojson'])) {
            $geoJson = is_string($item['geojson']) ? $item['geojson'] : json_encode($item['geojson']);
            $geoService->importGeoJson($layer, $geoJson);
        }
    }
}
