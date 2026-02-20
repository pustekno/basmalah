<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;
use App\Models\Deposit;
use App\Models\User;
use Carbon\Carbon;

class GoalTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::where('email', 'superadmin@basmalah.com')->first();
        
        if (!$superAdmin) {
            $this->command->error('Super Admin user not found. Please run SuperAdminSeeder first.');
            return;
        }

        // Create Goals
        $goals = [
            [
                'title' => 'Pembangunan Gerbang Masjid',
                'description' => 'Dana untuk pembangunan gerbang utama masjid yang megah',
                'target_amount' => 50000000,
                'current_amount' => 0,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(4),
                'status' => 'active',
                'category' => 'Infrastruktur',
                'created_by' => $superAdmin->id,
            ],
            [
                'title' => 'Renovasi Masjid',
                'description' => 'Dana untuk renovasi dan perbaikan masjid',
                'target_amount' => 30000000,
                'current_amount' => 0,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(5),
                'status' => 'active',
                'category' => 'Infrastruktur',
                'created_by' => $superAdmin->id,
            ],
            [
                'title' => 'Santunan Anak Yatim',
                'description' => 'Program santunan bulanan untuk anak yatim',
                'target_amount' => 10000000,
                'current_amount' => 0,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(2),
                'status' => 'active',
                'category' => 'Sosial',
                'created_by' => $superAdmin->id,
            ],
            [
                'title' => 'Pembangunan Perpustakaan',
                'description' => 'Pembangunan perpustakaan masjid',
                'target_amount' => 25000000,
                'current_amount' => 0,
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->subMonths(1),
                'status' => 'completed',
                'category' => 'Pendidikan',
                'created_by' => $superAdmin->id,
            ],
            [
                'title' => 'Program Tahfidz',
                'description' => 'Dana operasional program tahfidz Al-Quran',
                'target_amount' => 15000000,
                'current_amount' => 0,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(5),
                'status' => 'active',
                'category' => 'Pendidikan',
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($goals as $goalData) {
            Goal::create($goalData);
        }

        // Create Deposits
        $goal1 = Goal::where('title', 'Pembangunan Gerbang Masjid')->first();
        $goal2 = Goal::where('title', 'Renovasi Masjid')->first();
        $goal3 = Goal::where('title', 'Santunan Anak Yatim')->first();
        $goal4 = Goal::where('title', 'Pembangunan Perpustakaan')->first();

        $deposits = [
            // Deposits for Goal 1 (Gerbang Masjid)
            [
                'goal_id' => $goal1->id,
                'donor_name' => 'H. Ahmad Dahlan',
                'amount' => 10000000,
                'notes' => 'Semoga bermanfaat untuk pembangunan masjid',
                'deposit_date' => Carbon::now()->subMonths(2),
                'payment_method' => 'Transfer Bank',
                'recorded_by' => $superAdmin->id,
            ],
            [
                'goal_id' => $goal1->id,
                'donor_name' => 'Hj. Fatimah',
                'amount' => 5000000,
                'notes' => 'Infaq untuk gerbang masjid',
                'deposit_date' => Carbon::now()->subMonths(1)->subDays(15),
                'payment_method' => 'Cash',
                'recorded_by' => $superAdmin->id,
            ],
            [
                'goal_id' => $goal1->id,
                'donor_name' => 'Jamaah Jumat',
                'amount' => 3500000,
                'notes' => 'Kumpulan infaq Jumat',
                'deposit_date' => Carbon::now()->subDays(20),
                'payment_method' => 'Cash',
                'recorded_by' => $superAdmin->id,
            ],
            [
                'goal_id' => $goal1->id,
                'donor_name' => 'PT. Berkah Sejahtera',
                'amount' => 15000000,
                'notes' => 'CSR perusahaan',
                'deposit_date' => Carbon::now()->subDays(10),
                'payment_method' => 'Transfer Bank',
                'recorded_by' => $superAdmin->id,
            ],
            
            // Deposits for Goal 2 (Renovasi)
            [
                'goal_id' => $goal2->id,
                'donor_name' => 'Bapak Usman',
                'amount' => 7500000,
                'notes' => 'Untuk renovasi masjid',
                'deposit_date' => Carbon::now()->subMonths(1),
                'payment_method' => 'Transfer Bank',
                'recorded_by' => $superAdmin->id,
            ],
            [
                'goal_id' => $goal2->id,
                'donor_name' => 'Ibu Aisyah',
                'amount' => 2500000,
                'notes' => null,
                'deposit_date' => Carbon::now()->subDays(15),
                'payment_method' => 'E-Wallet',
                'recorded_by' => $superAdmin->id,
            ],
            
            // Deposits for Goal 3 (Santunan)
            [
                'goal_id' => $goal3->id,
                'donor_name' => 'Donatur Anonim',
                'amount' => 5000000,
                'notes' => 'Untuk anak yatim',
                'deposit_date' => Carbon::now()->subMonths(1),
                'payment_method' => 'Transfer Bank',
                'recorded_by' => $superAdmin->id,
            ],
            [
                'goal_id' => $goal3->id,
                'donor_name' => 'Keluarga Besar Pak Haji',
                'amount' => 3500000,
                'notes' => 'Santunan anak yatim',
                'deposit_date' => Carbon::now()->subDays(10),
                'payment_method' => 'Cash',
                'recorded_by' => $superAdmin->id,
            ],
            
            // Deposits for Goal 4 (Perpustakaan - Completed)
            [
                'goal_id' => $goal4->id,
                'donor_name' => 'Alumni Pesantren',
                'amount' => 25000000,
                'notes' => 'Wakaf untuk perpustakaan',
                'deposit_date' => Carbon::now()->subMonths(3),
                'payment_method' => 'Transfer Bank',
                'recorded_by' => $superAdmin->id,
            ],
        ];

        foreach ($deposits as $depositData) {
            $deposit = Deposit::create($depositData);
            
            // Update goal current_amount
            $goal = Goal::find($deposit->goal_id);
            $goal->increment('current_amount', $deposit->amount);
            
            // Auto-complete if target reached
            if ($goal->current_amount >= $goal->target_amount && $goal->status === 'active') {
                $goal->update(['status' => 'completed']);
            }
        }

        $this->command->info('Sample goals and deposits created successfully!');
    }
}
