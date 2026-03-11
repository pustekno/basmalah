<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Deposit;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Goal::class);
        
        $goals = Goal::with('creator')
            ->withCount('deposits')
            ->withSum('deposits', 'amount')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        $this->authorize('create', Goal::class);
        
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Goal::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['current_amount'] = 0;
        $validated['progress_percentage'] = 0;
        $validated['status'] = 'active';
        $validated['masjid_id'] = $this->getMasjidId();

        Goal::create($validated);

        return redirect()->route('goals.index')
            ->with('success', 'Target berhasil dibuat!');
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

    public function show(Goal $goal)
    {
        $this->authorize('view', $goal);
        
        $goal->load(['creator']);
        
        $deposits = $goal->deposits()
            ->with(['account', 'recorder'])
            ->orderBy('deposit_date', 'desc')
            ->paginate(10);

        return view('goals.show', compact('goal', 'deposits'));
    }

    public function edit(Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $accounts = Account::all();
        $deposits = $goal->deposits()
            ->with(['account', 'recorder'])
            ->orderBy('deposit_date', 'desc')
            ->get();
        
        return view('goals.edit', compact('goal', 'accounts', 'deposits'));
    }

    public function update(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:active,completed,cancelled',
            'progress_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.edit', $goal)
            ->with('success', 'Target berhasil diupdate!');
    }

    /**
     * Add deposit to a goal from an account.
     * This will reduce the account balance.
     */
    public function addDeposit(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'deposit_date' => 'required|date',
        ]);

        // Get the account
        $account = Account::findOrFail($validated['account_id']);

        // Check if account has sufficient balance
        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Saldo akun tidak mencukupi! Saldo saat ini: ' . formatCurrency($account->balance));
        }

        // Start database transaction
        DB::beginTransaction();
        try {
            // Create the deposit
            $deposit = Deposit::create([
                'goal_id' => $goal->id,
                'account_id' => $validated['account_id'],
                'donor_name' => $validated['donor_name'],
                'amount' => $validated['amount'],
                'notes' => $validated['notes'],
                'deposit_date' => $validated['deposit_date'],
                'recorded_by' => Auth::id(),
                'masjid_id' => $this->getMasjidId(),
            ]);

            // Reduce account balance
            $account->balance -= $validated['amount'];
            $account->save();

            // Update goal's current_amount and progress_percentage
            $totalDeposits = $goal->deposits()->sum('amount');
            $goal->current_amount = $totalDeposits;
            // Note: progress_percentage is NOT updated here - it's set manually by admin for work progress
            // Auto-complete if deposit target is reached
            if ($goal->current_amount >= $goal->target_amount && $goal->status === 'active') {
                $goal->status = 'completed';
            }
            
            $goal->save();

            DB::commit();

            return redirect()->route('goals.edit', $goal)
                ->with('success', 'Deposit berhasil ditambahkan! Saldo akun berkurang sebesar ' . formatCurrency($validated['amount']));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update progress percentage manually (without deposit).
     */
    public function updateProgress(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validated = $request->validate([
            'progress_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $goal->progress_percentage = $validated['progress_percentage'];
        $goal->save();

        return redirect()->route('goals.edit', $goal)
            ->with('success', 'Progress berhasil diupdate!');
    }

    /**
     * Delete a deposit and restore account balance.
     */
    public function deleteDeposit(Goal $goal, Deposit $deposit)
    {
        $this->authorize('update', $goal);
        
        // Ensure the deposit belongs to this goal
        if ($deposit->goal_id !== $goal->id) {
            return back()->with('error', 'Deposit tidak valid!');
        }

        DB::beginTransaction();
        try {
            // Restore account balance
            $account = $deposit->account;
            if ($account) {
                $account->balance += $deposit->amount;
                $account->save();
            }

            // Delete the deposit
            $deposit->delete();

            // Update goal's current_amount
            $totalDeposits = $goal->deposits()->sum('amount');
            $goal->current_amount = $totalDeposits;
            // Note: progress_percentage is NOT updated here - it's set manually by admin for work progress
            
            // Update status if deposit target is no longer met
            if ($goal->current_amount < $goal->target_amount) {
                $goal->status = 'active';
            }
            
            $goal->save();

            DB::commit();

            return redirect()->route('goals.edit', $goal)
                ->with('success', 'Deposit berhasil dihapus dan saldo dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        
        // Restore account balances for all deposits
        foreach ($goal->deposits as $deposit) {
            if ($deposit->account) {
                $deposit->account->balance += $deposit->amount;
                $deposit->account->save();
            }
        }
        
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Target berhasil dihapus!');
    }
}
