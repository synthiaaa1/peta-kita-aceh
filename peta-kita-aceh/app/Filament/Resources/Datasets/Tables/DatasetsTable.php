<?php

namespace App\Filament\Resources\Datasets\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class DatasetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_path')
                    ->label('Sampul'),
                TextColumn::make('title')
                    ->label('Judul Dataset')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('agency.name')
                    ->label('Instansi / SKPA')
                    ->sortable(),
                TextColumn::make('metadata.mandatory_completeness')
                    ->label('Wajib')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 100 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (int $state): string => "{$state}%")
                    ->sortable(),
                TextColumn::make('metadata.recommended_completeness')
                    ->label('Opsional')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 40 => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => "{$state}%")
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'pending_review' => 'warning',
                        'rejected' => 'danger',
                        'draft' => 'secondary',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Disetujui (Tayang)',
                        'pending_review' => 'Menunggu Tinjauan',
                        'rejected' => 'Ditolak',
                        'draft' => 'Draft',
                        'archived' => 'Diarsipkan',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->isAdmin() && $record->status !== 'published')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Dataset')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui dataset ini agar tayang di publik?')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'published',
                            'published_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Dataset Disetujui')
                            ->body('Dataset telah disetujui dan saat ini sudah tayang ke publik.')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => auth()->user()?->isAdmin() && $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Dataset')
                    ->modalDescription('Apakah Anda yakin ingin menolak dataset ini?')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);
                        Notification::make()
                            ->title('Dataset Ditolak')
                            ->body('Dataset telah ditolak dan tidak akan ditayangkan ke publik.')
                            ->warning()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()?->isAdmin()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isAdmin()),
                ]),
            ]);
    }
}
