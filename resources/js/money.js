import Decimal from 'decimal.js';

/**
 * Money calculation helper using Decimal.js for precision
 * All amounts are stored as integers (cents) in the database
 */

// Configure Decimal.js
Decimal.set({ precision: 20, rounding: Decimal.ROUND_HALF_UP });

/**
 * Convert rupiah string to cents (integer)
 * @param {string|number} rupiah - Amount in rupiah
 * @returns {number} Amount in cents
 */
export function rupiahToCents(rupiah) {
    const cleaned = String(rupiah).replace(/[^\d.-]/g, '');
    const decimal = new Decimal(cleaned || 0);
    return decimal.times(100).toNumber();
}

/**
 * Convert cents (integer) to rupiah decimal
 * @param {number} cents - Amount in cents
 * @returns {Decimal} Amount in rupiah as Decimal object
 */
export function centsToRupiah(cents) {
    return new Decimal(cents || 0).dividedBy(100);
}

/**
 * Format cents to rupiah string
 * @param {number} cents - Amount in cents
 * @returns {string} Formatted rupiah string
 */
export function formatRupiah(cents) {
    const rupiah = centsToRupiah(cents);
    return 'Rp ' + rupiah.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

/**
 * Add two amounts in cents
 * @param {number} amount1 - First amount in cents
 * @param {number} amount2 - Second amount in cents
 * @returns {number} Sum in cents
 */
export function addMoney(amount1, amount2) {
    const decimal1 = new Decimal(amount1 || 0);
    const decimal2 = new Decimal(amount2 || 0);
    return decimal1.plus(decimal2).toNumber();
}

/**
 * Subtract two amounts in cents
 * @param {number} amount1 - First amount in cents
 * @param {number} amount2 - Second amount in cents
 * @returns {number} Difference in cents
 */
export function subtractMoney(amount1, amount2) {
    const decimal1 = new Decimal(amount1 || 0);
    const decimal2 = new Decimal(amount2 || 0);
    return decimal1.minus(decimal2).toNumber();
}

/**
 * Multiply amount by a factor
 * @param {number} amount - Amount in cents
 * @param {number} factor - Multiplication factor
 * @returns {number} Result in cents
 */
export function multiplyMoney(amount, factor) {
    const decimal = new Decimal(amount || 0);
    const factorDecimal = new Decimal(factor || 0);
    return decimal.times(factorDecimal).toNumber();
}

/**
 * Divide amount by a divisor
 * @param {number} amount - Amount in cents
 * @param {number} divisor - Division divisor
 * @returns {number} Result in cents
 */
export function divideMoney(amount, divisor) {
    if (divisor === 0) return 0;
    const decimal = new Decimal(amount || 0);
    const divisorDecimal = new Decimal(divisor);
    return decimal.dividedBy(divisorDecimal).toNumber();
}

/**
 * Format input field for rupiah
 * @param {HTMLInputElement} input - Input element
 */
export function setupRupiahInput(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value) {
            const formatted = parseInt(value).toLocaleString('id-ID');
            e.target.value = formatted;
        }
    });

    input.addEventListener('blur', function(e) {
        const cents = rupiahToCents(e.target.value);
        // Store cents value in a hidden input or data attribute
        const hiddenInput = document.getElementById(e.target.id + '_cents');
        if (hiddenInput) {
            hiddenInput.value = cents;
        }
    });
}

/**
 * Calculate total from array of amounts
 * @param {number[]} amounts - Array of amounts in cents
 * @returns {number} Total in cents
 */
export function calculateTotal(amounts) {
    return amounts.reduce((total, amount) => addMoney(total, amount), 0);
}

/**
 * Compare two amounts
 * @param {number} amount1 - First amount in cents
 * @param {number} amount2 - Second amount in cents
 * @returns {number} -1 if amount1 < amount2, 0 if equal, 1 if amount1 > amount2
 */
export function compareMoney(amount1, amount2) {
    const decimal1 = new Decimal(amount1 || 0);
    const decimal2 = new Decimal(amount2 || 0);
    return decimal1.comparedTo(decimal2);
}

// Export Decimal for advanced usage
export { Decimal };
