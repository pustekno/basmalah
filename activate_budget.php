<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Find and activate budget "tes"
$budget = \App\Models\Budget::where('name', 'tes')->first();

if (!$budget) {
    echo "Budget 'tes' not found\n";
    exit;
}

echo "=== UPDATING BUDGET ===\n";
echo "Before:\n";
echo "- Status: " . ($budget->is_active ? 'Active' : 'Inactive') . "\n";
echo "- Start Date: " . $budget->start_date . "\n";
echo "- End Date: " . $budget->end_date . "\n";

// Update to active and set current month dates
$budget->update([
    'is_active' => true,
    'start_date' => now()->startOfMonth(),
    'end_date' => now()->endOfMonth(),
]);

echo "\nAfter:\n";
echo "- Status: " . ($budget->is_active ? 'Active' : 'Inactive') . "\n";
echo "- Start Date: " . $budget->start_date . "\n";
echo "- End Date: " . $budget->end_date . "\n";
echo "- Total Spent: Rp " . number_format($budget->total_spent, 0, ',', '.') . "\n";

echo "\n✓ Budget activated successfully!\n";
echo "Reload the browser page to see the updated summary.\n";
