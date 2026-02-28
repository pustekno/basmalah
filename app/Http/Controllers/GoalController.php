<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::with('creator')
            ->withCount('deposits')
            ->withSum('deposits', 'amount')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
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

        Goal::create($validated);

        return redirect()->route('goals.index')
            ->with('success', 'Target berhasil dibuat!');
    }

    public function show(Goal $goal)
    {
        $goal->load(['creator']);
        
        $deposits = $goal->deposits()
            ->with('recorder')
            ->orderBy('deposit_date', 'desc')
            ->paginate(10);

        return view('goals.show', compact('goal', 'deposits'));
    }

    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
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
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Target berhasil dihapus!');
    }
}
