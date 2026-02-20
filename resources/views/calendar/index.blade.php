<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div>
                    <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                        {{ __('Transaction Calendar') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Track your financial activities at a glance</p>
                </div>
            </div>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
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
                <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <label for="account_filter" class="text-sm font-medium text-gray-600 dark:text-gray-400">Filter by Account</label>
                        <select id="account_filter" class="flex-1 min-w-[200px] px-4 py-2 bg-gray-50 dark:bg-gray-700 border-0 rounded-lg text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
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
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Legend</span>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Income</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Expense</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-violet-500"></span>
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
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
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
            
            // Premium theme colors
            const colors = {
                income: '#10b981',
                expense: '#f43f5e',
                mixed: '#8b5cf6',
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
                            
                            data.forEach(dayData => {
                                const hasIncome = dayData.total_income > 0;
                                const hasExpense = dayData.total_expense > 0;
                                const hasUpcoming = dayData.transactions.some(t => t.upcoming === true);
                                
                                let color = colors.mixed;
                                if (hasIncome && !hasExpense && !hasUpcoming) {
                                    color = colors.income;
                                } else if (hasExpense && !hasIncome && !hasUpcoming) {
                                    color = colors.expense;
                                } else if (hasUpcoming && !hasIncome && !hasExpense) {
                                    color = colors.upcoming;
                                }
                                
                                const incomeText = hasIncome ? `+Rp ${(dayData.total_income / 100).toLocaleString('id-ID')}` : '';
                                const expenseText = hasExpense ? `-Rp ${(dayData.total_expense / 100).toLocaleString('id-ID')}` : '';
                                const upcomingText = hasUpcoming ? '📅' : '';
                                const separator = (hasIncome && hasExpense) ? ' | ' : ((hasIncome || hasExpense) && hasUpcoming ? ' | ' : '');
                                
                                events.push({
                                    title: `${incomeText}${expenseText}${upcomingText}`,
                                    start: dayData.date,
                                    backgroundColor: color,
                                    borderColor: color,
                                    extendedProps: {
                                        transactions: dayData.transactions,
                                        totalIncome: dayData.total_income,
                                        totalExpense: dayData.total_expense,
                                        count: dayData.count
                                    }
                                });
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
                    let transactionsList = '<div class="space-y-3 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">';
                    
                    props.transactions.forEach(transaction => {
                        const typeColor = transaction.type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400';
                        const typeIcon = transaction.type === 'income' ? '↑' : '↓';
                        const isUpcoming = transaction.upcoming === true;
                        const upcomingBadge = isUpcoming ? '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300">Upcoming</span>' : '';
                        const opacity = isUpcoming ? 'opacity-70' : '';
                        
                        transactionsList += `
                            <div class="p-4.5 bg-gray-50/50 dark:bg-gray-700/30 rounded-2xl ${opacity} hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200 border border-gray-100 dark:border-gray-600 hover:border-emerald-200 dark:hover:border-emerald-800 hover:shadow-lg">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2.5 flex-wrap mb-2">
                                            <p class="font-bold text-gray-900 dark:text-gray-100">${transaction.category}</p>
                                            ${upcomingBadge}
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">${transaction.account}</p>
                                        ${transaction.description ? `<p class="text-xs text-gray-400 dark:text-gray-500 mt-2 line-clamp-2">${transaction.description}</p>` : ''}
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="${typeColor} font-extrabold text-lg">${typeIcon} ${transaction.formatted_amount}</p>
                                        <a href="/transactions/${transaction.id}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 hover:underline">View →</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    transactionsList += '</div>';
                    
                    const netAmount = props.totalIncome - props.totalExpense;
                    const netColor = netAmount >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400';
                    const netBg = netAmount >= 0 ? 'bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/40 dark:to-teal-900/20' : 'bg-gradient-to-r from-rose-50 to-orange-50 dark:from-rose-900/40 dark:to-orange-900/20';
                    const netBorder = netAmount >= 0 ? 'border-emerald-200 dark:border-emerald-800' : 'border-rose-200 dark:border-rose-800';
                    
                    const summary = `
                        <div class="mb-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/30 dark:from-emerald-900/50 dark:to-emerald-800/20 rounded-2xl border border-emerald-200/50 dark:border-emerald-800/30">
                                    <div class="flex items-center gap-2.5 mb-3">
                                        <span class="p-2 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl shadow-lg shadow-emerald-500/30">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                        </span>
                                        <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Income</p>
                                    </div>
                                    <p class="text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">+Rp ${(props.totalIncome / 100).toLocaleString('id-ID')}</p>
                                </div>
                                <div class="p-5 bg-gradient-to-br from-rose-50 to-rose-100/30 dark:from-rose-900/50 dark:to-rose-800/20 rounded-2xl border border-rose-200/50 dark:border-rose-800/30">
                                    <div class="flex items-center gap-2.5 mb-3">
                                        <span class="p-2 bg-gradient-to-br from-rose-400 to-rose-600 rounded-xl shadow-lg shadow-rose-500/30">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                        </span>
                                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Expense</p>
                                    </div>
                                    <p class="text-2xl font-extrabold text-rose-700 dark:text-rose-300">-Rp ${(props.totalExpense / 100).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                            <div class="p-5 ${netBg} rounded-2xl border-2 ${netBorder}">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <span class="p-2.5 ${netAmount >= 0 ? 'bg-gradient-to-br from-emerald-400 to-emerald-600' : 'bg-gradient-to-br from-rose-400 to-rose-600'} rounded-xl shadow-lg ${netAmount >= 0 ? 'shadow-emerald-500/30' : 'shadow-rose-500/30'}">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </span>
                                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Net Balance</p>
                                    </div>
                                    <p class="${netColor} font-extrabold text-3xl">Rp ${(netAmount / 100).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Create modal
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-md flex items-center justify-center z-50 p-4 sm:p-8';
                    modal.innerHTML = `
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden transform transition-all border border-gray-100 dark:border-gray-700">
                            <div class="p-7 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80 dark:from-gray-800 dark:via-gray-800/50 dark:to-gray-800">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl shadow-emerald-500/25">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                                Transactions
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">${info.event.startStr}</p>
                                        </div>
                                    </div>
                                    <button onclick="this.closest('.fixed').remove()" class="p-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-7 overflow-y-auto" style="max-height: calc(90vh - 220px);">
                                ${summary}
                                ${transactionsList}
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    // Close on outside click
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.remove();
                        }
                    });
                    
                    // Close on Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            modal.remove();
                        }
                    });
                },
                eventDidMount: function(info) {
                    info.el.style.cursor = 'pointer';
                    info.el.style.borderRadius = '10px';
                    info.el.style.fontSize = '11px';
                    info.el.style.fontWeight = '700';
                    info.el.style.padding = '5px 10px';
                    info.el.style.boxShadow = '0 3px 8px rgba(0,0,0,0.12)';
                    info.el.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)';
                    info.el.style.margin = '3px 0';
                    
                    info.el.addEventListener('mouseenter', function() {
                        info.el.style.transform = 'translateY(-3px) scale(1.02)';
                        info.el.style.boxShadow = '0 8px 20px rgba(0,0,0,0.2)';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        info.el.style.transform = 'translateY(0) scale(1)';
                        info.el.style.boxShadow = '0 3px 8px rgba(0,0,0,0.12)';
                    });
                }
            });
            
            calendar.render();
            
            // Reload calendar when account filter changes
            accountFilter.addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
    
    <style>
        /* Ultra Premium Calendar Styles */
        .calendar-ultra {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        
        .calendar-ultra .fc-toolbar {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .calendar-ultra .fc-toolbar-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.03em;
        }
        
        .calendar-ultra .fc-button {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important;
            border: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            padding: 0.75rem 1.25rem !important;
            border-radius: 1rem !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        }
        
        .calendar-ultra .fc-button:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
            border-color: #d1d5db !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08) !important;
        }
        
        .calendar-ultra .fc-button-primary:not(:disabled).fc-button-active,
        .calendar-ultra .fc-button-primary:not(:disabled):active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border-color: #10b981 !important;
            color: white !important;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .calendar-ultra .fc-daygrid-day-number {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px !important;
        }
        
        .calendar-ultra .fc-daygrid-day.fc-day-today {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
        }
        
        .calendar-ultra .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.4);
            font-weight: 700;
        }
        
        .calendar-ultra .fc-col-header-cell-cushion {
            color: #6b7280;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 16px 0 !important;
        }
        
        .calendar-ultra .fc-event {
            border: none !important;
            padding: 5px 10px !important;
        }
        
        .calendar-ultra .fc-daygrid-day-events {
            padding: 3px !important;
        }
        
        .calendar-ultra .fc-daygrid-more-link {
            color: #6b7280 !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            background: #f3f4f6;
            padding: 4px 8px;
            border-radius: 8px;
            margin: 2px 4px;
        }
        
        .calendar-ultra .fc-popover {
            border-radius: 20px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 12px 24px -8px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid #e5e7eb !important;
            overflow: hidden;
        }
        
        .calendar-ultra .fc-popover-header {
            background: linear-gradient(to right, #f9fafb, #f3f4f6) !important;
            font-weight: 800 !important;
            padding: 16px 20px !important;
            font-size: 0.9rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .calendar-ultra .fc-toolbar-title {
                color: #f9fafb;
            }
            
            .calendar-ultra .fc-button {
                background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important;
                border-color: #4b5563 !important;
                color: #e5e7eb !important;
            }
            
            .calendar-ultra .fc-button:hover {
                background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%) !important;
            }
            
            .calendar-ultra .fc-daygrid-day-number {
                color: #9ca3af;
            }
            
            .calendar-ultra .fc-daygrid-day.fc-day-today {
                background: linear-gradient(135deg, #064e3b 0%, #065f46 100%) !important;
            }
            
            .calendar-ultra .fc-col-header-cell-cushion {
                color: #9ca3af;
            }
            
            .calendar-ultra .fc-daygrid-more-link {
                color: #d1d5db !important;
                background: #4b5563;
            }
            
            .calendar-ultra .fc-toolbar {
                border-bottom-color: #374151;
            }
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
