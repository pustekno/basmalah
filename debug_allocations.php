<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$allocations = \App\Models\BudgetAllocation::with('budget', 'account')->get();
echo 'Total Allocations: ' . $allocations->count() . PHP_EOL;

if ($allocations->count() === 0) {
    echo 'No allocations found in database' . PHP_EOL;
} else {
    foreach ($allocations as $a) {
        echo 'Budget: ' . $a->budget->name . ' | Account: ' . $a->account->name . ' | Amount: ' . $a->amount . PHP_EOL;
    }
}

// Also check accounts balance
echo "\n--- Account Balances ---\n";
$accounts = \App\Models\Account::all();
foreach ($accounts as $a) {
    echo $a->name . ': Rp ' . number_format($a->balance, 0, ',', '.') . PHP_EOL;
}
