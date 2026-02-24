<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (admin)
        $user = User::first();

        if (!$user) {
            $this->command->error('No users found. Please run SuperAdminSeeder first.');
            return;
        }

        // Create sample accounts
        $kasAccount = Account::create([
            'name' => 'Kas Masjid',
            'type' => 'cash',
            'balance' => 5000000,
        ]);

        $bankAccount = Account::create([
            'name' => 'Bank Syariah',
            'type' => 'bank',
            'balance' => 15000000,
        ]);

        $infaqAccount = Account::create([
            'name' => 'Kotak Infaq',
            'type' => 'cash',
            'balance' => 2500000,
        ]);

        // Create sample transactions for the last 30 days
        $transactions = [
            // Income transactions
            [
                'account_id' => $kasAccount->id,
                'type' => 'income',
                'category' => 'Zakat',
                'amount' => 1000000,
                'description' => 'Zakat Fitrah dari Jamaah',
                'transaction_date' => Carbon::now()->subDays(25),
            ],
            [
                'account_id' => $infaqAccount->id,
                'type' => 'income',
                'category' => 'Infaq',
                'amount' => 500000,
                'description' => 'Infaq Jumat',
                'transaction_date' => Carbon::now()->subDays(20),
            ],
            [
                'account_id' => $bankAccount->id,
                'type' => 'income',
                'category' => 'Donasi',
                'amount' => 5000000,
                'description' => 'Donasi pembangunan dari donatur',
                'transaction_date' => Carbon::now()->subDays(15),
            ],
            [
                'account_id' => $kasAccount->id,
                'type' => 'income',
                'category' => 'Sedekah',
                'amount' => 750000,
                'description' => 'Sedekah dari acara pengajian',
                'transaction_date' => Carbon::now()->subDays(10),
            ],
            [
                'account_id' => $infaqAccount->id,
                'type' => 'income',
                'category' => 'Infaq',
                'amount' => 300000,
                'description' => 'Infaq Jumat',
                'transaction_date' => Carbon::now()->subDays(5),
            ],
            
            // Expense transactions
            [
                'account_id' => $kasAccount->id,
                'type' => 'expense',
                'category' => 'Operasional',
                'amount' => 500000,
                'description' => 'Listrik dan air bulan ini',
                'transaction_date' => Carbon::now()->subDays(22),
            ],
            [
                'account_id' => $kasAccount->id,
                'type' => 'expense',
                'category' => 'Perlengkapan',
                'amount' => 350000,
                'description' => 'Pembelian sajadah dan mukena',
                'transaction_date' => Carbon::now()->subDays(18),
            ],
            [
                'account_id' => $kasAccount->id,
                'type' => 'expense',
                'category' => 'Pengajian',
                'amount' => 200000,
                'description' => 'Honor ustadz pengajian rutin',
                'transaction_date' => Carbon::now()->subDays(12),
            ],
            [
                'account_id' => $bankAccount->id,
                'type' => 'expense',
                'category' => 'Pembangunan',
                'amount' => 3000000,
                'description' => 'Renovasi kamar mandi masjid',
                'transaction_date' => Carbon::now()->subDays(8),
            ],
            [
                'account_id' => $kasAccount->id,
                'type' => 'expense',
                'category' => 'Santunan',
                'amount' => 1000000,
                'description' => 'Santunan anak yatim',
                'transaction_date' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }

        $this->command->info('Sample accounts and transactions created successfully!');
        $this->command->info('- Created 3 accounts');
        $this->command->info('- Created ' . count($transactions) . ' transactions');
    }
}
