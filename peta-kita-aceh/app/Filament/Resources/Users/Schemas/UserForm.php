<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('role')
                    ->label('Peran (Role)')
                    ->options([
                        'admin' => 'Admin (Super Administrator)',
                        'operator' => 'Operator Dinas / SKPA',
                    ])
                    ->default('operator')
                    ->required(),
                Select::make('agency_id')
                    ->label('Instansi / SKPA (Dinas)')
                    ->relationship('agency', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih Instansi/Dinas di Provinsi Aceh.'),
                Select::make('sector')
                    ->label('Bidang / Sektor')
                    ->options([
                        'ekonomi' => 'Ekonomi & Pembangunan',
                        'infrastruktur' => 'Infrastruktur & Penataan Ruang',
                        'lingkungan' => 'Lingkungan Hidup & Kehutanan',
                        'kesehatan' => 'Kesehatan & Pelayanan Sosial',
                        'pendidikan' => 'Pendidikan & Kebudayaan',
                        'tata_pemerintahan' => 'Tata Pemerintahan & Administrasi',
                    ])
                    ->searchable()
                    ->nullable(),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
            ]);
    }
}
