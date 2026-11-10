<?php

namespace App\Filament\Resources\Layers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class LayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')->schema([
                    Select::make('dataset_id')
                        ->label('Dataset Spasial')
                        ->relationship('dataset', 'title', modifyQueryUsing: function ($query) {
                            $user = auth()->user();
                            if ($user && $user->isOperator() && $user->agency_id) {
                                $query->where('agency_id', $user->agency_id);
                            }
                        })
                        ->required(),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Select::make('geometry_type')
                        ->options([
                            'point' => 'Point',
                            'line' => 'Line',
                            'polygon' => 'Polygon',
                            'raster' => 'Raster',
                        ]),
                    Select::make('source_type')
                        ->options([
                            'vector_table' => 'Vector Table',
                            'vector_tile' => 'Vector Tile',
                            'raster_tile' => 'Raster Tile',
                            'external_wms' => 'External WMS',
                        ]),
                    TextInput::make('source_reference')
                        ->maxLength(255),
                    Toggle::make('is_active')
                        ->required()
                        ->default(true),
                ])->columns(2),

                Section::make('Upload Format Spasial (GeoJSON & Shapefile)')->schema([
                    FileUpload::make('spatial_file')
                        ->label('File Spasial (GeoJSON atau ESRI Shapefile ZIP)')
                        ->acceptedFileTypes([
                            'application/json',
                            'application/geo+json',
                            'application/zip',
                            'application/x-zip-compressed',
                            'application/octet-stream',
                        ])
                        ->disk('local')
                        ->directory('spatial-uploads')
                        ->dehydrated(false)
                        ->helperText('Mendukung format GeoJSON (.json / .geojson) dan ESRI Shapefile Bundle (.zip berisi file .shp, .shx, .dbf, .prj). Sistem akan memproses dan menyimpan koordinat secara otomatis.')
                ]),

                Section::make('Tampilan & Pewarnaan Layer (Layer Style)')
                    ->relationship('style')
                    ->schema([
                        ColorPicker::make('fill_color')
                            ->label('Warna Isian (Fill Color)')
                            ->default('#198754'),
                        ColorPicker::make('stroke_color')
                            ->label('Warna Garis Tepi (Stroke Color)')
                            ->default('#0f5132'),
                        TextInput::make('stroke_width')
                            ->label('Ketebalan Garis (px)')
                            ->numeric()
                            ->default(2),
                        TextInput::make('opacity')
                            ->label('Transparansi / Opacity (0.0 - 1.0)')
                            ->numeric()
                            ->default(0.8),
                    ])->columns(2)
            ]);
    }
}

