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
        Schema::table('categories', function (Blueprint $table) {
            // Only add icon_name column if it doesn't exist
            if (!Schema::hasColumn('categories', 'icon_name')) {
                $table->string('icon_name')->default('tag')->after('icon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'icon_name')) {
                $table->dropColumn('icon_name');
            }
        });
    }
};
