<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'operator' => 'info',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Admin Super',
                        'operator' => 'Operator Dinas',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('agency.name')
                    ->label('Instansi / SKPA')
                    ->placeholder('Semua Dinas / Global')
                    ->sortable(),
                TextColumn::make('sector')
                    ->label('Bidang / Sektor')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'ekonomi' => 'Ekonomi & Pembangunan',
                        'infrastruktur' => 'Infrastruktur & Penataan Ruang',
                        'lingkungan' => 'Lingkungan Hidup & Kehutanan',
                        'kesehatan' => 'Kesehatan & Pelayanan Sosial',
                        'pendidikan' => 'Pendidikan & Kebudayaan',
                        'tata_pemerintahan' => 'Tata Pemerintahan & Administrasi',
                        default => $state ?? '-',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Terdaftar Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
