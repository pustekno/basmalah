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
            if (!Schema::hasColumn('categories', 'icon_name')) {
                $table->string('icon_name')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('categories', 'masjid_id')) {
                $table->foreignId('masjid_id')->nullable()->constrained('masjids')->onDelete('cascade');
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
            if (Schema::hasColumn('categories', 'masjid_id')) {
                $table->dropColumn('masjid_id');
            }
        });
    }
};
