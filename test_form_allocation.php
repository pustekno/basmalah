<?php
include 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// First verify current state
echo "=== BEFORE ALLOCATION ===\n";
$budget = \App\Models\Budget::where('name', 'Test Budget - Operasional')->first();
$account = \App\Models\Account::where('name', 'Bank Syariah')->first();

echo "Budget: " . $budget->name . "\n";
echo "- Amount: " . number_format($budget->amount, 0, ',', '.') . "\n";
echo "- Total Spent: " . number_format($budget->total_spent, 0, ',', '.') . "\n";
echo "- Allocations count: " . $budget->allocations()->count() . "\n\n";

echo "Account: " . $account->name . "\n";
echo "- Balance: " . number_format($account->balance, 0, ',', '.') . "\n\n";

// Simulate allocation form submission
echo "=== SIMULATING ALLOCATION (5.000.000) ===\n";

// Mock an authenticated user
auth()->loginUsingId(1);

$controller = new \App\Http\Controllers\BudgetController();
$request = new \Illuminate\Http\Request();
$request->setMethod('POST');
$request->merge([
    'account_id' => $account->id,
    'amount' => '5000000', // This is what would come from form
    'description' => 'Test Allocation via CLI',
]);
$request->setUserResolver(function() {
    return auth()->user();
});

// Validate
$validated = $request->validate([
    'account_id' => 'required|exists:accounts,id',
    'amount' => 'required|numeric|min:1',
    'description' => 'nullable|string|max:255',
]);

// Process amount like controller does
$amountString = $validated['amount'] ?? '0';
$amount = (int) preg_replace('/\D/', '', strval($amountString));

echo "Parsed amount: " . number_format($amount, 0, ',', '.') . "\n\n";

try {
    $budget->allocateFunds(
        $validated['account_id'],
        $amount,
        $validated['description'],
        auth()->id()
    );
    echo "✓ Allocation created successfully!\n\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
    exit;
}

// Check results
echo "=== AFTER ALLOCATION ===\n";
$budget->refresh();
$account->refresh();

echo "Budget: " . $budget->name . "\n";
echo "- Amount: " . number_format($budget->amount, 0, ',', '.') . "\n";
echo "- Total Spent: " . number_format($budget->total_spent, 0, ',', '.') . "\n";
echo "- Allocations count: " . $budget->allocations()->count() . "\n";
echo "- Percentage used: " . $budget->percentage_used . "%\n\n";

echo "Account: " . $account->name . "\n";
echo "- Balance: " . number_format($account->balance, 0, ',', '.') . "\n\n";

// Show allocation detail
$latest = $budget->allocations()->latest()->first();
if ($latest) {
    echo "Latest Allocation:\n";
    echo "- ID: " . $latest->id . "\n";
    echo "- Amount: " . number_format($latest->amount, 0, ',', '.') . "\n";
    echo "- Account: " . $latest->account->name . "\n";
    echo "- Description: " . $latest->description . "\n";
    echo "- Created at: " . $latest->allocated_at . "\n";
}
