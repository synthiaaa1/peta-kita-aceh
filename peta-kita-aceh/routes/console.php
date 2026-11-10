<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi otomatis data peta SIG Aceh (143 dataset) & BNPB setiap hari
Schedule::command('sig:sync-aceh')->daily();
