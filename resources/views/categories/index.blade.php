<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-emerald-700 transition-colors shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Income Categories -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Income Categories
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($incomeCategories as $category)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:shadow-lg transition">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20">
                                            <svg class="w-5 h-5" style="color: {{ $category->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($category->children->count() > 0)
                                    <div class="mb-3 pl-4 border-l-2 border-gray-200 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Sub-categories:</p>
                                        @foreach($category->children as $child)
                                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-1">• {{ $child->name }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('categories.show', $category) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700">View</a>
                                    <a href="{{ route('categories.edit', $category) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
                                No income categories found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Expense Categories -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                        Expense Categories
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($expenseCategories as $category)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:shadow-lg transition">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20">
                                            <svg class="w-5 h-5" style="color: {{ $category->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($category->children->count() > 0)
                                    <div class="mb-3 pl-4 border-l-2 border-gray-200 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Sub-categories:</p>
                                        @foreach($category->children as $child)
                                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-1">• {{ $child->name }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('categories.show', $category) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700">View</a>
                                    <a href="{{ route('categories.edit', $category) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
                                No expense categories found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
