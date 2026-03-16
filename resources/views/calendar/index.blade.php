<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Transaction Calendar
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Track your financial activities at a glance</p>
                </div>
            </div>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-yellow-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter & Legend Row -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Filter -->
                <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex flex-wrap items-center gap-4">
                        <label for="account_filter" class="text-sm font-medium text-gray-600 dark:text-gray-400">Filter by Account</label>
                        <select id="account_filter" class="flex-1 min-w-[200px] px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="">All Accounts</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ $selectedAccount == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Legend -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="space-y-3">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Legend</span>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Income</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Expense</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-yellow-300"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Mixed</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Upcoming</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6">
                    <div id="calendar" class="calendar-ultra"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const accountFilter = document.getElementById('account_filter');
            
            // Gold theme colors
            const colors = {
                income: '#f59e0b',
                expense: '#6b7280',
                mixed: '#fbbf24',
                upcoming: '#fbbf24'
            };
            
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,listMonth'
                },
                height: 'auto',
                dayMaxEvents: 3,
                moreLinkClick: 'popover',
                nowIndicator: true,
                eventDisplay: 'block',
                events: function(info, successCallback, failureCallback) {
                    const accountId = accountFilter.value;
                    const month = info.start.getMonth() + 1;
                    const year = info.start.getFullYear();
                    
                    fetch(`{{ route('calendar.transactions') }}?month=${month}&year=${year}&account_id=${accountId}`)
                        .then(response => response.json())
                        .then(data => {
                            const events = [];
                            
                            data.forEach(item => {
                                if (item.type === 'transaction') {
                                    const hasIncome = item.total_income > 0;
                                    const hasExpense = item.total_expense > 0;
                                    const hasUpcoming = item.transactions.some(t => t.upcoming === true);
                                    
                                    let color = colors.mixed;
                                    if (hasIncome && !hasExpense && !hasUpcoming) {
                                        color = colors.income;
                                    } else if (hasExpense && !hasIncome && !hasUpcoming) {
                                        color = colors.expense;
                                    } else if (hasUpcoming && !hasIncome && !hasExpense) {
                                        color = colors.upcoming;
                                    }
                                    
                                    const incomeText = hasIncome ? `+Rp ${(item.total_income / 100).toLocaleString('id-ID')}` : '';
                                    const expenseText = hasExpense ? `-Rp ${(item.total_expense / 100).toLocaleString('id-ID')}` : '';
                                    const upcomingText = hasUpcoming ? '📅' : '';
                                    
                                    events.push({
                                        title: `${incomeText}${expenseText}${upcomingText}`,
                                        start: item.date,
                                        backgroundColor: color,
                                        borderColor: color,
                                        extendedProps: {
                                            type: 'transaction',
                                            transactions: item.transactions,
                                            totalIncome: item.total_income,
                                            totalExpense: item.total_expense,
                                            count: item.count
                                        }
                                    });
                                } else if (item.type === 'budget_start') {
                                    events.push({
                                        title: `🎯 ${item.budget.name} Start`,
                                        start: item.date,
                                        backgroundColor: '#f59e0b',
                                        borderColor: '#d97706',
                                        textColor: '#ffffff',
                                        extendedProps: {
                                            type: 'budget_start',
                                            budget: item.budget
                                        }
                                    });
                                } else if (item.type === 'budget_end') {
                                    const bgColor = item.budget.exceeded ? '#ef4444' : '#f59e0b';
                                    const borderColor = item.budget.exceeded ? '#dc2626' : '#d97706';
                                    
                                    events.push({
                                        title: `🏁 ${item.budget.name} End (${item.budget.percentage}%)`,
                                        start: item.date,
                                        backgroundColor: bgColor,
                                        borderColor: borderColor,
                                        textColor: '#ffffff',
                                        extendedProps: {
                                            type: 'budget_end',
                                            budget: item.budget
                                        }
                                    });
                                } else if (item.type === 'goal_start') {
                                    events.push({
                                        title: `🎯 ${item.goal.name} Start`,
                                        start: item.date,
                                        backgroundColor: '#8b5cf6',
                                        borderColor: '#7c3aed',
                                        textColor: '#ffffff',
                                        extendedProps: {
                                            type: 'goal_start',
                                            goal: item.goal
                                        }
                                    });
                                } else if (item.type === 'goal_end') {
                                    const goalStatusColor = item.goal.status === 'completed' ? '#10b981' : (item.goal.status === 'active' ? '#f59e0b' : '#6b7280');
                                    events.push({
                                        title: `🏁 ${item.goal.name} End (${item.goal.progress_percentage}%)`,
                                        start: item.date,
                                        backgroundColor: goalStatusColor,
                                        borderColor: item.goal.status === 'completed' ? '#059669' : (item.goal.status === 'active' ? '#d97706' : '#4b5563'),
                                        textColor: '#ffffff',
                                        extendedProps: {
                                            type: 'goal_end',
                                            goal: item.goal
                                        }
                                    });
                                } else if (item.type === 'goal_deposit') {
                                    events.push({
                                        title: `💰 Deposit: ${item.deposit.goal_name}`,
                                        start: item.date,
                                        backgroundColor: '#22c55e',
                                        borderColor: '#16a34a',
                                        textColor: '#ffffff',
                                        extendedProps: {
                                            type: 'goal_deposit',
                                            deposit: item.deposit
                                        }
                                    });
                                }
                            });
                            
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error fetching transactions:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    
                    if (props.type === 'budget_start') {
                        const budget = props.budget;
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-100 dark:border-slate-700">
                                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-yellow-600 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Started</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Budget Name</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${budget.name}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Budget Amount</p>
                                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">${budget.formatted_amount}</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex gap-3">
                                        <a href="/budgets/${budget.id}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-4 rounded-xl text-center transition">
                                            View Budget
                                        </a>
                                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-xl transition">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        modal.addEventListener('click', (e) => e.target === modal && modal.remove());
                        return;
                    }
                    
                    if (props.type === 'budget_end') {
                        const budget = props.budget;
                        const statusColor = budget.exceeded ? 'red' : 'yellow';
                        const statusText = budget.exceeded ? 'Over Budget!' : 'Within Budget';
                        
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-100 dark:border-slate-700">
                                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-${statusColor}-500 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Ended</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-${statusColor}-100 text-${statusColor}-700 dark:bg-${statusColor}-900/60 dark:text-${statusColor}-300">
                                                ${statusText}
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3 mb-2">
                                            <div class="h-3 rounded-full bg-yellow-500" style="width: ${Math.min(budget.percentage, 100)}%"></div>
                                        </div>
                                        <p class="text-right text-sm font-bold text-gray-900 dark:text-white">${budget.percentage}%</p>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Budget Name</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${budget.name}</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Budget</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">${budget.formatted_amount}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Spent</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">${budget.formatted_spent}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 flex gap-3">
                                        <a href="/budgets/${budget.id}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-4 rounded-xl text-center transition">
                                            View Details
                                        </a>
                                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-xl transition">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        modal.addEventListener('click', (e) => e.target === modal && modal.remove());
                        return;
                    }
                    
                    if (props.type === 'goal_start') {
                        const goal = props.goal;
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-100 dark:border-slate-700">
                                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-purple-600 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Goal Started</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Goal Name</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${goal.name}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Target Amount</p>
                                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp ${new Intl.NumberFormat('id-ID').format(goal.target_amount)}</p>
                                        </div>
                                        ${goal.category ? `<div><p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Category</p><p class="text-sm font-medium text-gray-900 dark:text-white">${goal.category}</p></div>` : ''}
                                    </div>
                                    <div class="mt-6 flex gap-3">
                                        <a href="/goals/${goal.id}/edit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl text-center transition">
                                            View Details
                                        </a>
                                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-xl transition">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        modal.addEventListener('click', (e) => e.target === modal && modal.remove());
                        return;
                    }
                    
                    if (props.type === 'goal_end') {
                        const goal = props.goal;
                        const statusColor = goal.status === 'completed' ? 'green' : (goal.status === 'active' ? 'yellow' : 'gray');
                        const statusText = goal.status === 'completed' ? 'Completed' : (goal.status === 'active' ? 'Active' : 'Cancelled');
                        
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-100 dark:border-slate-700">
                                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-${statusColor}-500 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Goal Ended</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-${statusColor}-100 text-${statusColor}-700 dark:bg-${statusColor}-900/60 dark:text-${statusColor}-300">
                                                ${statusText}
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3 mb-2">
                                            <div class="h-3 rounded-full bg-purple-500" style="width: ${Math.min(goal.progress_percentage, 100)}%"></div>
                                        </div>
                                        <p class="text-right text-sm font-bold text-gray-900 dark:text-white">${goal.progress_percentage}%</p>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Goal Name</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${goal.name}</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Target</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">Rp ${new Intl.NumberFormat('id-ID').format(goal.target_amount)}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Collected</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">Rp ${new Intl.NumberFormat('id-ID').format(goal.current_amount)}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 flex gap-3">
                                        <a href="/goals/${goal.id}/edit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl text-center transition">
                                            View Details
                                        </a>
                                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-xl transition">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        modal.addEventListener('click', (e) => e.target === modal && modal.remove());
                        return;
                    }
                    
                    if (props.type === 'goal_deposit') {
                        const deposit = props.deposit;
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-100 dark:border-slate-700">
                                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-green-500 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Deposit Received</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Goal</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${deposit.goal_name}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Amount</p>
                                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">+Rp ${new Intl.NumberFormat('id-ID').format(deposit.amount)}</p>
                                        </div>
                                        ${deposit.donor_name ? `<div><p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Donor</p><p class="text-sm font-medium text-gray-900 dark:text-white">${deposit.donor_name}</p></div>` : ''}
                                        ${deposit.notes ? `<div><p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Notes</p><p class="text-sm text-gray-600 dark:text-gray-400">${deposit.notes}</p></div>` : ''}
                                    </div>
                                    <div class="mt-6 flex gap-3">
                                        <a href="/goals" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-xl text-center transition">
                                            View Goals
                                        </a>
                                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-xl transition">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        modal.addEventListener('click', (e) => e.target === modal && modal.remove());
                        return;
                    }
                    
                    // Transaction events
                    let transactionsList = '<div class="space-y-3 max-h-[320px] overflow-y-auto pr-2">';
                    
                    props.transactions.forEach(transaction => {
                        const typeColor = transaction.type === 'income' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400';
                        const typeIcon = transaction.type === 'income' ? '↑' : '↓';
                        const isUpcoming = transaction.upcoming === true;
                        const upcomingBadge = isUpcoming ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/60 dark:text-yellow-300">Upcoming</span>' : '';
                        const opacity = isUpcoming ? 'opacity-70' : '';
                        
                        transactionsList += `
                            <div class="p-4 bg-gray-50 dark:bg-slate-700/30 rounded-xl ${opacity} hover:bg-gray-100 dark:hover:bg-slate-700/50 transition-all border border-gray-100 dark:border-slate-600">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <p class="font-medium text-gray-900 dark:text-white">${transaction.category}</p>
                                            ${upcomingBadge}
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">${transaction.account}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="${typeColor} font-bold text-lg">${typeIcon} ${transaction.formatted_amount}</p>
                                        <a href="/transactions/${transaction.id}" class="text-xs font-medium text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300">View →</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    transactionsList += '</div>';
                    
                    const netAmount = props.totalIncome - props.totalExpense;
                    const netColor = netAmount >= 0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400';
                    
                    const summary = `
                        <div class="mb-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-5 bg-gray-50 dark:bg-slate-700/30 rounded-xl border border-gray-100 dark:border-slate-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="p-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                        </span>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Income</p>
                                    </div>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">+Rp ${(props.totalIncome / 100).toLocaleString('id-ID')}</p>
                                </div>
                                <div class="p-5 bg-gray-50 dark:bg-slate-700/30 rounded-xl border border-gray-100 dark:border-slate-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="p-2 bg-gray-100 dark:bg-slate-600 rounded-lg">
                                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                        </span>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Expense</p>
                                    </div>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">-Rp ${(props.totalExpense / 100).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                            <div class="p-5 bg-gray-50 dark:bg-slate-700/30 rounded-xl border border-gray-100 dark:border-slate-600">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Net Balance</p>
                                    <p class="${netColor} font-bold text-2xl">Rp ${(netAmount / 100).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Create modal
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
                    modal.innerHTML = `
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden border border-gray-100 dark:border-slate-700">
                            <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-yellow-600 rounded-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Transactions</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                    <button onclick="this.closest('.fixed').remove()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 200px);">
                                ${summary}
                                ${transactionsList}
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.remove();
                        }
                    });
                    
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            modal.remove();
                        }
                    });
                },
                eventDidMount: function(info) {
                    info.el.style.cursor = 'pointer';
                    info.el.style.borderRadius = '8px';
                    info.el.style.fontSize = '11px';
                    info.el.style.fontWeight = '600';
                    info.el.style.padding = '4px 8px';
                    info.el.style.margin = '2px 0';
                    info.el.style.transition = 'all 0.2s ease';
                    
                    info.el.addEventListener('mouseenter', function() {
                        info.el.style.transform = 'translateY(-2px)';
                        info.el.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        info.el.style.transform = 'translateY(0)';
                        info.el.style.boxShadow = 'none';
                    });
                }
            });
            
            calendar.render();
            
            accountFilter.addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
    
    <style>
        .calendar-ultra {
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        .calendar-ultra .fc-toolbar {
            margin-bottom: 1.5rem;
        }
        
        .calendar-ultra .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }
        
        .calendar-ultra .fc-button {
            background-color: #f3f4f6 !important;
            border-color: #e5e7eb !important;
            color: #374151 !important;
            font-weight: 500 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
        }
        
        .calendar-ultra .fc-button:hover {
            background-color: #e5e7eb !important;
        }
        
        .calendar-ultra .fc-button-primary:not(:disabled).fc-button-active,
        .calendar-ultra .fc-button-primary:not(:disabled):active {
            background-color: #f59e0b !important;
            border-color: #f59e0b !important;
            color: white !important;
        }
        
        .calendar-ultra .fc-daygrid-day {
            transition: background-color 0.2s;
        }
        
        .calendar-ultra .fc-daygrid-day:hover {
            background-color: #f9fafb;
        }
        
        .calendar-ultra .fc-daygrid-day-number {
            font-weight: 500;
            color: #374151;
            padding: 0.5rem;
        }
        
        .calendar-ultra .fc-col-header-cell-cushion {
            font-weight: 600;
            color: #6b7280;
            padding: 0.75rem 0;
        }
        
        .calendar-ultra .fc-event {
            border: none !important;
        }
        
        .calendar-ultra .fc-day-today {
            background-color: #fef3c7 !important;
        }
        
        .calendar-ultra .fc-day-today .fc-daygrid-day-number {
            background-color: #f59e0b;
            color: white;
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Dark mode styles for FullCalendar */
        .dark .calendar-ultra .fc-toolbar-title {
            color: #f3f4f6 !important;
        }
        
        .dark .calendar-ultra .fc-button {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f3f4f6 !important;
        }
        
        .dark .calendar-ultra .fc-button:hover {
            background-color: #4b5563 !important;
        }
        
        .dark .calendar-ultra .fc-button-primary:not(:disabled).fc-button-active,
        .dark .calendar-ultra .fc-button-primary:not(:disabled):active {
            background-color: #D4A017 !important;
            border-color: #D4A017 !important;
            color: white !important;
        }
        
        .dark .calendar-ultra .fc-daygrid-day:hover {
            background-color: #374151 !important;
        }
        
        .dark .calendar-ultra .fc-daygrid-day-number {
            color: #e5e7eb !important;
        }
        
        .dark .calendar-ultra .fc-col-header-cell-cushion {
            color: #9ca3af !important;
        }
        
        .dark .calendar-ultra .fc-day-today {
            background-color: #451a03 !important;
        }
        
        .dark .calendar-ultra .fc-scrollgrid {
            border-color: #374151 !important;
        }
        
        .dark .calendar-ultra .fc-col-header-cell {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark .calendar-ultra .fc-daygrid-day {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark .calendar-ultra .fc-day-other .fc-daygrid-day-number {
            color: #6b7280 !important;
        }
        
        .dark .calendar-ultra .fc-highlight {
            background-color: #374151 !important;
        }
        
        .dark .calendar-ultra .fc-timegrid-slot {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
    </style>
</x-app-layout>
