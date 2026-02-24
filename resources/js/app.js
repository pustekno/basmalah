import './bootstrap';

import Alpine from 'alpinejs';
import * as Money from './money';

window.Alpine = Alpine;
window.Money = Money;

// Transaction Form Alpine Component
document.addEventListener('alpine:init', () => {
    Alpine.data('transactionForm', function() {
        return {
            type: this.$el.dataset.type || 'expense',
            amount: this.$el.dataset.amount || 0,
            amountDisplay: this.$el.dataset.amount ? this.formatAmount(this.$el.dataset.amount) : '',
            
            // Category options based on type
            incomeCategories: [
                { value: 'Zakat', label: 'Zakat' },
                { value: 'Infaq', label: 'Infaq' },
                { value: 'Sedekah', label: 'Sedekah' },
                { value: 'Donasi', label: 'Donasi' },
                { value: 'Lainnya', label: 'Lainnya' }
            ],
            expenseCategories: [
                { value: 'Operasional', label: 'Operasional' },
                { value: 'Perlengkapan', label: 'Perlengkapan' },
                { value: ' Kegiatan', label: ' Kegiatan' },
                { value: 'Lainnya', label: 'Lainnya' }
            ],
            
            get categories() {
                return this.type === 'income' ? this.incomeCategories : this.expenseCategories;
            },
            
            init() {
                // Initialize with data attributes if available
                if (this.$el.dataset.type) {
                    this.type = this.$el.dataset.type;
                }
                if (this.$el.dataset.amount) {
                    this.amount = parseInt(this.$el.dataset.amount);
                    this.amountDisplay = this.formatAmount(this.amount);
                }
                
                // Check URL params for type
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('type')) {
                    this.type = urlParams.get('type');
                }
                
                // Reset category when type changes
                this.$watch('type', () => {
                    const categorySelect = document.getElementById('category');
                    if (categorySelect) {
                        categorySelect.value = '';
                    }
                });
            },
            
            formatAmount(cents) {
                return (cents / 100).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
            },
            
            updateAmount() {
                // Support decimal input (Indonesian format: 1.000,50 or standard: 1000.50)
                let value = this.amountDisplay;
                
                // Handle Indonesian number format (1.000,50)
                if (value.includes(',') && value.includes('.')) {
                    // Indonesian format: remove dots (thousands), replace comma with dot
                    value = value.replace(/\./g, '').replace(',', '.');
                } else if (value.includes(',')) {
                    // Only comma - could be decimal separator
                    value = value.replace(',', '.');
                } else {
                    // Remove all non-digit except dot
                    value = value.replace(/[^\d.]/g, '');
                }
                
                if (value) {
                    const decimalValue = parseFloat(value);
                    if (!isNaN(decimalValue)) {
                        // Convert to cents
                        this.amount = Math.round(decimalValue * 100);
                        // Format display with thousand separators
                        this.amountDisplay = decimalValue.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                    }
                } else {
                    this.amount = 0;
                }
            },
            
            formatCurrencyInput(event) {
                // Format as user types for better UX
                let value = event.target.value.replace(/[^\d]/g, '');
                if (value) {
                    event.target.value = parseInt(value).toLocaleString('id-ID');
                }
            }
        };
    });
});

Alpine.start();
