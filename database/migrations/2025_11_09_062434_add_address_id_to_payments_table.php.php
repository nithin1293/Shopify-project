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
        Schema::table('payments', function (Blueprint $table) {
            // Add the new address_id column
            // It's nullable just in case some payments aren't for physical goods
            $table->foreignId('address_id')->nullable()->after('phone')->constrained('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // This ensures you can roll back the migration
            $table->dropForeign(['address_id']);
            $table->dropColumn('address_id');
        });
    }
};
