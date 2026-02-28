<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Category') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="mb-6">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Parent Category -->
                        <div class="mb-6">
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Parent Category (Optional)
                            </label>
                            <select name="parent_id" id="parent_id"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">None (Main Category)</option>
                                
                                <optgroup label="Income Categories">
                                    @foreach($parentCategories->where('type', 'income') as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                
                                <optgroup label="Expense Categories">
                                    @foreach($parentCategories->where('type', 'expense') as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div class="mb-6">
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Color
                            </label>
                            <div class="flex gap-2 items-center">
                                <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}"
                                    class="h-10 w-20 rounded-lg border-gray-300 dark:border-gray-700 cursor-pointer">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Choose a color for this category</span>
                            </div>
                            @error('color')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div class="mb-6">
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Display Order
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $category->order) }}" min="0"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            @error('order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 dark:border-gray-700 text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-lg">
                                Update Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-colors text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
