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
        $parentCategories = Category::parents()->active()->orderBy('name')->get();
        return view('categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
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
