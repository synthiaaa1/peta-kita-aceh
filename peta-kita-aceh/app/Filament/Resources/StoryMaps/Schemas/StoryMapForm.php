<?php

namespace App\Filament\Resources\StoryMaps\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

class StoryMapForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Informasi Utama')
                        ->columnSpan(2)
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Story Map')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true),
                            TextInput::make('url')
                                ->label('URL Eksternal (Opsional)')
                                ->url()
                                ->placeholder('https://storymaps.arcgis.com/...')
                                ->helperText('Jika diisi, Story Map akan diarahkan ke URL ini.'),
                            FileUpload::make('cover_image')
                                ->label('Gambar Sampul')
                                ->image()
                                ->directory('story-maps')
                                ->disk('public'),
                        ]),
                    Section::make('Pengaturan')
                        ->columnSpan(1)
                        ->schema([
                            Select::make('author_id')
                                ->label('Penulis')
                                ->relationship('author', 'name')
                                ->default(auth()->id())
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->required()
                                ->default('draft'),
                            DateTimePicker::make('published_at')
                                ->label('Tanggal Tayang')
                                ->default(now()),
                        ]),
                ]),
                
                Section::make('Narasi dan Peta (Bagian-bagian Cerita)')
                    ->schema([
                        Repeater::make('sections')
                            ->relationship('sections')
                            ->orderColumn('order')
                            ->schema([
                                RichEditor::make('narrative_text')
                                    ->label('Teks Narasi')
                                    ->required()
                                    ->columnSpanFull(),
                                FileUpload::make('media_path')
                                    ->label('Media Tambahan (Opsional)')
                                    ->image()
                                    ->directory('story-maps/media'),
                                
                                Grid::make(3)->schema([
                                    TextInput::make('lat')
                                        ->label('Latitude')
                                        ->numeric()
                                        ->default(4.695)
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            if ($record && $record->map_state_json && isset($record->map_state_json['lat'])) {
                                                $component->state($record->map_state_json['lat']);
                                            }
                                        })
                                        ->dehydrated(false) // We save this in map_state_json
                                        ->required(),
                                    TextInput::make('lng')
                                        ->label('Longitude')
                                        ->numeric()
                                        ->default(96.749)
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            if ($record && $record->map_state_json && isset($record->map_state_json['lng'])) {
                                                $component->state($record->map_state_json['lng']);
                                            }
                                        })
                                        ->dehydrated(false) // We save this in map_state_json
                                        ->required(),
                                    TextInput::make('zoom')
                                        ->label('Tingkat Zoom')
                                        ->numeric()
                                        ->default(8)
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            if ($record && $record->map_state_json && isset($record->map_state_json['zoom'])) {
                                                $component->state($record->map_state_json['zoom']);
                                            }
                                        })
                                        ->dehydrated(false) // We save this in map_state_json
                                        ->required(),
                                ]),
                                
                                \Filament\Forms\Components\Hidden::make('map_state_json')
                                    ->dehydrateStateUsing(function ($state, \Filament\Schemas\Components\Utilities\Get $get) {
                                        return [
                                            'lat' => (float) $get('lat'),
                                            'lng' => (float) $get('lng'),
                                            'zoom' => (int) $get('zoom'),
                                        ];
                                    }),
                            ])
                            ->defaultItems(0)
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => isset($state['narrative_text']) ? Str::limit(strip_tags($state['narrative_text']), 50) : null),
                    ]),
            ]);
    }
}
