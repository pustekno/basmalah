<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$masjids = \App\Models\Masjid::all();

echo "Total Masjids: " . $masjids->count() . "\n\n";

foreach ($masjids as $masjid) {
    echo "ID: {$masjid->id}\n";
    echo "Name: {$masjid->name}\n";
    echo "Active: " . ($masjid->is_active ? 'Yes' : 'No') . "\n";
    echo "---\n";
}
