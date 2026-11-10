<?php

namespace App\Filament\Resources\Datasets\Pages;

use App\Filament\Resources\Datasets\DatasetResource;
use App\Services\SigAcehIntegrationService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListDatasets extends ListRecords
{
    protected static string $resource = DatasetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('sync_sig_aceh')
                ->label('Integrasi API SIG Aceh (v2)')
                ->icon('heroicon-m-arrow-path')
                ->color('emerald')
                ->requiresConfirmation()
                ->modalHeading('Tarik 143 Dataset Publik SIG Aceh (sig.acehprov.go.id/api/v2)')
                ->modalDescription('Sistem akan menarik dan memperbarui dataset spasial publik secara otomatis dari Endpoint API v2 SIG Aceh.')
                ->action(function (SigAcehIntegrationService $service) {
                    $result = $service->syncSigAcehDatasets();
                    Notification::make()
                        ->title('Integrasi API Berhasil')
                        ->body($result['message'])
                        ->success()
                        ->send();
                }),
            Action::make('sync_bnpb')
                ->label('Tarik Data BNPB (Nasional)')
                ->icon('heroicon-m-cloud-arrow-down')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Integrasi Data Kebencanaan Spasial BNPB')
                ->modalDescription('Sistem akan menarik data rawan bencana pesisir & darat Provinsi Aceh dari API BNPB.')
                ->action(function (SigAcehIntegrationService $service) {
                    $result = $service->syncNationalBnpbData();
                    Notification::make()
                        ->title('Integrasi Data BNPB Berhasil')
                        ->body($result['message'])
                        ->warning()
                        ->send();
                }),
        ];
    }
}
