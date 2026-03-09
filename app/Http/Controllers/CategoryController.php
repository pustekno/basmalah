<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        
        $categories = Category::with('children', 'parent')
            ->parents()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $incomeCategories = Category::with('children')
            ->parents()
            ->byType('income')
            ->orderBy('order')
            ->get();

        $expenseCategories = Category::with('children')
            ->parents()
            ->byType('expense')
            ->orderBy('order')
            ->get();

        return view('categories.index', compact('categories', 'incomeCategories', 'expenseCategories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        
        $parentCategories = Category::parents()->active()->orderBy('name')->get();
        return view('categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
        ]);

        // Add masjid_id
        $validated['masjid_id'] = $this->getMasjidId();

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
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

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);
        
        $category->load('children', 'parent', 'budgets');
        
        // Get transactions for this category
        $transactions = $category->transactions()
            ->with('account')
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        return view('categories.show', compact('category', 'transactions'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        
        $parentCategories = Category::parents()
            ->active()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        
        if ($category->hasChildren()) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with sub-categories.');
        }

        if ($category->transactions()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with existing transactions.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
