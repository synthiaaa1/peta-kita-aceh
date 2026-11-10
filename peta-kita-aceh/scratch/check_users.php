<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Users in database:\n";
foreach (\App\Models\User::all() as $u) {
    echo "- ID: {$u->id} | Name: {$u->name} | Email: {$u->email} | Role: {$u->role}\n";
}
