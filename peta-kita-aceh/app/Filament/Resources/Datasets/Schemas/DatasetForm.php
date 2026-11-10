<?php

namespace App\Filament\Resources\Datasets\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Section;

class DatasetForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();
        $isAdmin = $user?->isAdmin();

        return $schema
            ->components([
                Tabs::make('Dataset Metadata')
                    ->tabs([
                        Tabs\Tab::make('Identitas Data')
                            ->icon('heroicon-m-identification')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Dataset')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('metadata.alternative_title')
                                    ->label('Judul Alternatif (Opsional)')
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('Abstrak / Deskripsi')
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                TextInput::make('metadata.purpose')
                                    ->label('Tujuan Pembuatan Data')
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->label('Kategori Utama')
                                    ->relationship('category', 'name')
                                    ->required(),
                                Select::make('metadata.topic_category')
                                    ->label('Kategori Topik (ISO)')
                                    ->options([
                                        'farming' => 'Farming',
                                        'biota' => 'Biota',
                                        'boundaries' => 'Boundaries',
                                        'climatologyMeteorologyAtmosphere' => 'Climatology/Meteorology/Atmosphere',
                                        'economy' => 'Economy',
                                        'elevation' => 'Elevation',
                                        'environment' => 'Environment',
                                        'geoscientificInformation' => 'Geoscientific Information',
                                        'health' => 'Health',
                                        'imageryBaseMapsEarthCover' => 'Imagery/Base Maps/Earth Cover',
                                        'intelligenceMilitary' => 'Intelligence/Military',
                                        'inlandWaters' => 'Inland Waters',
                                        'location' => 'Location',
                                        'oceans' => 'Oceans',
                                        'planningCadastre' => 'Planning/Cadastre',
                                        'society' => 'Society',
                                        'structure' => 'Structure',
                                        'transportation' => 'Transportation',
                                        'utilitiesCommunication' => 'Utilities/Communication',
                                    ]),
                                Select::make('metadata.dataset_type')
                                    ->label('Tipe Dataset')
                                    ->options([
                                        'dataset' => 'Dataset (Satu Kumpulan Data)',
                                        'series' => 'Series (Kumpulan Dataset Terkait)',
                                        'service' => 'Service (Layanan Web/API)',
                                    ])
                                    ->default('dataset'),
                                TagsInput::make('metadata.keywords')
                                    ->label('Kata Kunci (Keywords)')
                                    ->placeholder('Tekan enter untuk menambah')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tabs\Tab::make('Kontak & Produsen')
                            ->icon('heroicon-m-user-group')
                            ->schema([
                                Select::make('agency_id')
                                    ->label('Instansi Walidata (SKPA)')
                                    ->relationship('agency', 'name')
                                    ->default(fn() => $user?->agency_id)
                                    ->disabled(!$isAdmin)
                                    ->dehydrated()
                                    ->required(),
                                TextInput::make('metadata.contact_person')
                                    ->label('Nama Kontak / Penanggung Jawab')
                                    ->maxLength(255),
                                TextInput::make('metadata.contact_email')
                                    ->label('Email Kontak')
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('metadata.contact_phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(50),
                                TextInput::make('metadata.metadata_author')
                                    ->label('Penyusun Metadata')
                                    ->maxLength(255),
                                Select::make('user_id')
                                    ->label('Pengunggah (Sistem)')
                                    ->relationship('user', 'name')
                                    ->default(fn() => $user?->id)
                                    ->disabled(!$isAdmin)
                                    ->dehydrated()
                                    ->required(),
                            ])->columns(2),

                        Tabs\Tab::make('Spasial & Temporal')
                            ->icon('heroicon-m-globe-asia-australia')
                            ->schema([
                                Section::make('Informasi Spasial')->schema([
                                    Select::make('metadata.spatial_representation_type')
                                        ->label('Tipe Representasi Spasial')
                                        ->options([
                                            'vector' => 'Vector',
                                            'grid' => 'Grid (Raster)',
                                            'textTable' => 'Text Table',
                                            'tin' => 'TIN',
                                            'stereoModel' => 'Stereo Model',
                                            'video' => 'Video',
                                        ]),
                                    Select::make('metadata.geometry_type')
                                        ->label('Tipe Geometri')
                                        ->options([
                                            'Point' => 'Point',
                                            'LineString' => 'LineString',
                                            'Polygon' => 'Polygon',
                                            'MultiPoint' => 'MultiPoint',
                                            'MultiLineString' => 'MultiLineString',
                                            'MultiPolygon' => 'MultiPolygon',
                                        ]),
                                    TextInput::make('srid')
                                        ->label('Sistem Referensi Spasial (EPSG Code)')
                                        ->numeric()
                                        ->default(4326)
                                        ->required(),
                                    TextInput::make('metadata.coordinate_system')
                                        ->label('Nama CRS (Misal: WGS 84)'),
                                    TextInput::make('metadata.scale_denominator')
                                        ->label('Skala Data (Misal: 50000 untuk 1:50.000)')
                                        ->numeric(),
                                ])->columns(2),

                                Section::make('Informasi Temporal (Waktu)')->schema([
                                    TextInput::make('year')
                                        ->label('Tahun Data Utama')
                                        ->default(date('Y'))
                                        ->numeric(),
                                    Select::make('metadata.update_frequency')
                                        ->label('Frekuensi Pembaruan')
                                        ->options([
                                            'continual' => 'Terus-menerus',
                                            'daily' => 'Harian',
                                            'weekly' => 'Mingguan',
                                            'fortnightly' => 'Dua Mingguan',
                                            'monthly' => 'Bulanan',
                                            'quarterly' => 'Kuartalan',
                                            'biannually' => 'Dua Kali Setahun',
                                            'annually' => 'Tahunan',
                                            'asNeeded' => 'Sesuai Kebutuhan',
                                            'irregular' => 'Tidak Teratur',
                                            'notPlanned' => 'Tidak Direncanakan',
                                            'unknown' => 'Tidak Diketahui',
                                        ]),
                                    DatePicker::make('metadata.temporal_start')
                                        ->label('Waktu Mulai Data'),
                                    DatePicker::make('metadata.temporal_end')
                                        ->label('Waktu Selesai Data'),
                                    DatePicker::make('metadata.last_update_date')
                                        ->label('Tanggal Pembaruan Terakhir (Update)'),
                                ])->columns(2),
                            ]),

                        Tabs\Tab::make('Kualitas & Sumber')
                            ->icon('heroicon-m-check-badge')
                            ->schema([
                                TextInput::make('metadata.source')
                                    ->label('Sumber Data Utama')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('metadata.data_quality_statement')
                                    ->label('Pernyataan Kualitas Data (Quality Statement)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('metadata.lineage')
                                    ->label('Riwayat Pembentukan Data (Lineage)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('metadata.accuracy_statement')
                                    ->label('Pernyataan Akurasi (Posisi / Atribut)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('metadata.completeness_statement')
                                    ->label('Pernyataan Kelengkapan Data')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Distribusi & Akses')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Select::make('status')
                                    ->label('Status Publikasi')
                                    ->options($isAdmin ? [
                                        'draft' => 'Draft',
                                        'pending_review' => 'Menunggu Tinjauan Admin',
                                        'published' => 'Disetujui (Tayang ke Publik)',
                                        'rejected' => 'Ditolak',
                                        'archived' => 'Diarsipkan',
                                    ] : [
                                        'draft' => 'Draft',
                                        'pending_review' => 'Kirim untuk Ditinjau Admin',
                                    ])
                                    ->default($isAdmin ? 'published' : 'pending_review')
                                    ->disabled(fn ($record) => !$isAdmin && $record && $record->status === 'published')
                                    ->required(),
                                Select::make('access_level')
                                    ->label('Kategori Akses Data')
                                    ->options([
                                        'public' => 'Terbuka (Dapat dilihat publik)',
                                        'restricted' => 'Terbatas (Hanya Instansi Terpilih)',
                                        'private' => 'Tertutup (Hanya Admin)',
                                    ])
                                    ->default('public')
                                    ->live()
                                    ->required(),
                                Select::make('allowedAgencies')
                                    ->label('Dinas / Instansi Terizin (Tag)')
                                    ->relationship('allowedAgencies', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->visible(fn ($get) => $get('access_level') === 'restricted')
                                    ->helperText('Pilih dinas yang diizinkan mengakses data ini saat status Akses Terbatas.')
                                    ->columnSpanFull(),

                                TextInput::make('license')
                                    ->label('Lisensi Data')
                                    ->default('Open Data')
                                    ->maxLength(255),
                                TextInput::make('metadata.download_format')
                                    ->label('Format Unduhan Standar')
                                    ->default('GeoJSON')
                                    ->maxLength(50),
                                Textarea::make('metadata.usage_constraints')
                                    ->label('Batasan Penggunaan (Usage Constraints)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                FileUpload::make('thumbnail_path')
                                    ->label('Gambar Sampul (Thumbnail)')
                                    ->image()
                                    ->directory('dataset-thumbnails')
                                    ->columnSpanFull(),
                                TextInput::make('metadata.metadata_identifier')
                                    ->label('Identifier Metadata')
                                    ->disabled()
                                    ->helperText('Dibuat otomatis oleh sistem saat data disimpan.')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])->columnSpanFull()
            ]);
    }
}
