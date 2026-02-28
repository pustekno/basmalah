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
            'donor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'deposit_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
        ]);

        $validated['goal_id'] = $goal->id;
        $validated['recorded_by'] = Auth::id();

        DB::transaction(function () use ($validated, $goal) {
            $deposit = Deposit::create($validated);
            
            // Update goal current_amount
            $goal->increment('current_amount', $deposit->amount);
            
            // Auto-complete goal if target reached
            if ($goal->current_amount >= $goal->target_amount && $goal->status === 'active') {
                $goal->update(['status' => 'completed']);
            }
        });

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Deposit berhasil dicatat!');
    }

    public function destroy(Deposit $deposit)
    {
        $goal = $deposit->goal;
        
        DB::transaction(function () use ($deposit, $goal) {
            // Adjust goal amount
            $goal->decrement('current_amount', $deposit->amount);
            
            // Delete deposit
            $deposit->delete();
        });

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Deposit berhasil dihapus!');
    }
}
