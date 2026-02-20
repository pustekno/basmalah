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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->string('donor_name');
            $table->decimal('amount', 15, 2);
            $table->text('notes')->nullable();
            $table->date('deposit_date');
            $table->string('payment_method')->nullable(); // Cash, Transfer, etc
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
