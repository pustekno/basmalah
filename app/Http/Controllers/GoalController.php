<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->with('recorder')
            ->orderBy('deposit_date', 'desc')
            ->paginate(10);

        return view('goals.show', compact('goal', 'deposits'));
    }

    public function edit(Goal $goal)
    {
        $this->authorize('update', $goal);
        
        return view('goals.edit', compact('goal'));
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
            'current_amount' => 'required|numeric|min:0',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Target berhasil diupdate!');
    }

    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Target berhasil dihapus!');
    }
}
