<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CustomLogin extends BaseLogin
{
    public function getHeading(): string|Htmlable
    {
        return 'Masuk ke Portal Management';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Masuk dengan akun Admin atau Operator Dinas Anda.';
    }
}
