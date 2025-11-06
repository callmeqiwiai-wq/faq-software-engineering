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
        if (!Schema::hasColumn('users', 'surname')) {
            Schema::table('users', function (Blueprint $table) {
                // make nullable to avoid breaking existing records; registration requires it, so it will be populated
                $table->string('surname')->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'surname')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('surname');
            });
        }
    }
};
