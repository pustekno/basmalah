<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate what the controller does
$masjids = \App\Models\Masjid::where('is_active', true)->get();

echo "Query Result:\n";
echo "Total Masjids: " . $masjids->count() . "\n\n";

if ($masjids->isEmpty()) {
    echo "WARNING: No masjids found!\n";
} else {
    echo "Masjids found:\n";
    foreach ($masjids as $masjid) {
        echo "- ID: {$masjid->id}, Name: {$masjid->name}\n";
    }
}
