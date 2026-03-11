<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$budget = \App\Models\Budget::where('name', 'tes')->first();

if (!$budget) {
    echo "Budget not found\n";
    exit;
}

echo "Current time: " . \Carbon\Carbon::now() . "\n";
echo "Budget dates:\n";
echo "- Start: " . $budget->start_date . "\n";
echo "- End: " . $budget->end_date . "\n";

// Update end_date to end of month (end of day)
$budget->update([
    'end_date' => now()->endOfMonth()->endOfDay(),
]);

echo "\nUpdated:\n";
echo "- End: " . $budget->end_date . "\n";

// Check if it matches the scope
$now = \Carbon\Carbon::now();
echo "\nCheck current() scope:\n";
echo "- is_active: " . ($budget->is_active ? 'true' : 'false') . "\n";
echo "- start_date <= now: " . ($budget->start_date <= $now ? 'true' : 'false') . "\n";
echo "- end_date >= now: " . ($budget->end_date >= $now ? 'true' : 'false') . "\n";

// Verify it shows in current()
$current = \App\Models\Budget::current()->where('name', 'tes')->first();
if ($current) {
    echo "\n✓ Budget now appears in current() scope!\n";
    echo "Total Spent: Rp " . number_format($current->total_spent, 0, ',', '.') . "\n";
} else {
    echo "\n✗ Budget still not in current() scope\n";
}
