<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Find the budget "tes"
$budget = \App\Models\Budget::where('name', 'tes')->first();

if (!$budget) {
    echo "Budget 'tes' not found\n";
    exit;
}

// Get accounts for allocation
$accounts = \App\Models\Account::all();

if ($accounts->isEmpty()) {
    echo "No accounts found\n";
    exit;
}

echo "=== FILLING BUDGET: " . $budget->name . " ===\n";
echo "Budget Amount: " . number_format($budget->amount, 0, ',', '.') . "\n\n";

// Create multiple allocations
$allocations = [
    [
        'account' => 'Bank Syariah',
        'amount' => 50000000,
        'description' => 'Alokasi awal operasional'
    ],
    [
        'account' => 'Kas Masjid',
        'amount' => 25000000,
        'description' => 'Dana tambahan kas'
    ],
    [
        'account' => 'Kotak Infaq',
        'amount' => 15000000,
        'description' => 'Infaq tambahan'
    ],
];

auth()->loginUsingId(1);

foreach ($allocations as $alloc) {
    $account = \App\Models\Account::where('name', $alloc['account'])->first();
    
    if (!$account) {
        echo "✗ Account '{$alloc['account']}' not found, skipping\n";
        continue;
    }
    
    try {
        $budget->allocateFunds(
            $account->id,
            $alloc['amount'],
            $alloc['description'],
            1
        );
        echo "✓ Allocated Rp " . number_format($alloc['amount'], 0, ',', '.') . " from {$alloc['account']}\n";
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }
}

// Refresh and show results
$budget->refresh();

echo "\n=== RESULTS ===\n";
echo "Total Budget: Rp " . number_format($budget->amount, 0, ',', '.') . "\n";
echo "Total Spent: Rp " . number_format($budget->total_spent, 0, ',', '.') . "\n";
echo "Remaining: Rp " . number_format($budget->remaining, 0, ',', '.') . "\n";
echo "Usage: " . $budget->percentage_used . "%\n";
echo "Total Allocations: " . $budget->allocations()->count() . "\n";

echo "\n✓ Budget filled successfully!\n";
echo "Reload the page in browser to see the updated data.\n";
