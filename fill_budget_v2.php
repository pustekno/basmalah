<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== UPDATING ACCOUNT BALANCES ===\n";

// Update accounts with bigger balance
$updates = [
    'Bank Syariah' => 500000000,       // 500 juta
    'Kas Masjid' => 300000000,         // 300 juta
    'Kotak Infaq' => 200000000,        // 200 juta
];

foreach ($updates as $name => $balance) {
    $account = \App\Models\Account::where('name', $name)->first();
    if ($account) {
        $account->update(['balance' => $balance]);
        echo "✓ Updated {$name}: Rp " . number_format($balance, 0, ',', '.') . "\n";
    } else {
        echo "✗ Account '{$name}' not found\n";
    }
}

echo "\n=== ALLOCATING TO BUDGET ===\n";

// Find the budget "tes"
$budget = \App\Models\Budget::where('name', 'tes')->first();

if (!$budget) {
    echo "Budget 'tes' not found\n";
    exit;
}

// Create allocations with updated balances
$allocations = [
    [
        'account' => 'Bank Syariah',
        'amount' => 100000000,
        'description' => 'Alokasi awal - Transfer bank'
    ],
    [
        'account' => 'Kas Masjid',
        'amount' => 75000000,
        'description' => 'Alokasi kas - Kebutuhan operasional'
    ],
    [
        'account' => 'Kotak Infaq',
        'amount' => 50000000,
        'description' => 'Alokasi infaq - Sosial'
    ],
];

auth()->loginUsingId(1);

foreach ($allocations as $alloc) {
    $account = \App\Models\Account::where('name', $alloc['account'])->first();
    
    if (!$account) {
        echo "✗ Account '{$alloc['account']}' not found\n";
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

echo "\n=== BUDGET RESULTS ===\n";
echo "Total Budget: Rp " . number_format($budget->amount, 0, ',', '.') . "\n";
echo "Total Spent: Rp " . number_format($budget->total_spent, 0, ',', '.') . "\n";
echo "Remaining: Rp " . number_format($budget->remaining, 0, ',', '.') . "\n";
echo "Usage: " . $budget->percentage_used . "%\n";
echo "Total Allocations: " . $budget->allocations()->count() . "\n";

echo "\n=== ACCOUNT BALANCES ===\n";
foreach (\App\Models\Account::all() as $acc) {
    echo $acc->name . ": Rp " . number_format($acc->balance, 0, ',', '.') . "\n";
}

echo "\n✓ Done! Reload browser page to see updates.\n";
