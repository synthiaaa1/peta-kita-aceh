<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CustomRegister extends BaseRegister
{
    public function getHeading(): string|Htmlable
    {
        return 'Pendaftaran Akun Geoportal';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return new HtmlString('Sudah punya akun? Silakan masuk melalui halaman login.');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                Select::make('role')
                    ->label('Peran (Role)')
                    ->options([
                        'operator' => 'Operator Dinas / SKPA',
                        'admin' => 'Admin Super',
                    ])
                    ->default('operator')
                    ->required(),
                Select::make('agency_id')
                    ->label('Instansi / SKPA (Semua Dinas)')
                    ->relationship('agency', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih Dinas/SKPA tempat Anda bertugas (jika Operator).'),
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
                    ->nullable()
                    ->helperText('Pilih Bidang/Sektor pengelolaan data.'),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
