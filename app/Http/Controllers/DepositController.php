<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function create(Goal $goal)
    {
        return view('deposits.create', compact('goal'));
    }

    public function store(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'donor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'deposit_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
        ]);

        $validated['goal_id'] = $goal->id;
        $validated['recorded_by'] = Auth::id();
        $validated['masjid_id'] = $this->getMasjidId();

        // Check if account has sufficient balance
        $account = \App\Models\Account::findOrFail($validated['account_id']);
        if ($account->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Saldo akun tidak mencukupi!'])->withInput();
        }

        DB::transaction(function () use ($validated, $goal, $account) {
            $deposit = Deposit::create($validated);
            
            // Update goal current_amount (for deposit tracking only)
            $goal->increment('current_amount', $deposit->amount);
            
            // Deduct from account balance
            $account->decrement('balance', $deposit->amount);
            
            // Auto-complete goal if deposit target reached (but work progress may still be different)
            if ($goal->current_amount >= $goal->target_amount && $goal->status === 'active') {
                $goal->update(['status' => 'completed']);
            }
        });

        return redirect()->route('goals.edit', $goal)
            ->with('success', 'Deposit berhasil dicatat dan saldo akun telah dikurangi!');
    }

    /**
     * Get masjid_id for current user.
     */
    private function getMasjidId(): ?int
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return session('active_masjid_id');
        }

        return $user->masjid_id;
    }

    public function destroy(Deposit $deposit)
    {
        $goal = $deposit->goal;
        $account = $deposit->account;
        
        DB::transaction(function () use ($deposit, $goal, $account) {
            // Adjust goal current_amount (for deposit tracking only)
            $goal->decrement('current_amount', $deposit->amount);
            
            // Return balance to account if account exists
            if ($account) {
                $account->increment('balance', $deposit->amount);
            }
            
            // Delete deposit
            $deposit->delete();
        });

        return redirect()->route('goals.edit', $goal)
            ->with('success', 'Deposit berhasil dihapus dan saldo dikembalikan!');
    }
}
