<?php

namespace App\Filament\Resources\ThematicMaps\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ThematicMapForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('type')
                    ->options([
                        'interactive' => 'Interactive',
                        'layout' => 'Layout (Statis)',
                    ])
                    ->required()
                    ->default('interactive'),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->required()
                    ->default('draft'),
                TextInput::make('source_url')
                    ->label('URL Sumber (Opsional)')
                    ->helperText('Isi jika peta ini mengarah ke dasbor eksternal (misal: ArcGIS/PowerBI). Kosongkan untuk WebGIS bawaan.')
                    ->url()
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thematic_maps/thumbnails'),
                FileUpload::make('file_path')
                    ->label('File Layout (PDF/Gambar)')
                    ->disk('public')
                    ->directory('thematic_maps/layouts'),
                Textarea::make('config_json')
                    ->label('Config JSON (Untuk Interactive)')
                    ->columnSpanFull()
                    ->rows(6),
                Select::make('agency_id')
                    ->relationship('agency', 'name')
                    ->label('Instansi / OPD')
                    ->required(),
            ]);
    }
}
