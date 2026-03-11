<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulate test allocation
$budget = \App\Models\Budget::where('name', 'Test Budget - Operasional')->first();
$account = \App\Models\Account::where('name', 'Bank Syariah')->first();

if (!$budget) {
    echo "Budget not found\n";
    exit;
}

if (!$account) {
    echo "Account not found\n";
    exit;
}

echo "Testing allocation:\n";
echo "Budget: " . $budget->name . " (Amount: " . $budget->amount . ")\n";
echo "Account before: " . $account->name . " (Balance: " . $account->balance . ")\n\n";

try {
    // Create fake auth user for testing
    auth()->loginUsingId(1);
    
    // Test allocation
    $amount = 5000000; // 5 juta
    $budget->allocateFunds($account->id, $amount, 'Test allocation', 1);
    
    // Refresh models
    $budget->refresh();
    $account->refresh();
    
    echo "✓ Allocation successful!\n";
    echo "Account after: " . $account->name . " (Balance: " . $account->balance . ")\n";
    echo "Budget allocation created\n";
    
    $allocation = $budget->allocations()->first();
    if ($allocation) {
        echo "Allocation amount: " . $allocation->amount . "\n";
        echo "Budget total_spent: " . $budget->total_spent . "\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
