<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->enum('type', ['income', 'expense'])->default('expense');
            $table->string('category');
            $table->bigInteger('amount'); // Store as integer (cents)
            $table->text('description')->nullable();
            $table->string('proof_image')->nullable();
            $table->date('transaction_date');
            $table->boolean('upcoming_flag')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
