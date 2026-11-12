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
        Schema::table('memberships', function (Blueprint $table) {
            // Shown after the price, e.g. "£35 / year". Editor-set, so outside
            // what the Spektrix import writes. Defaults to "year" so existing and
            // newly imported memberships read as they always have.
            $table->string('price_period')->nullable()->default('year')->after('renewal_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('price_period');
        });
    }
};
