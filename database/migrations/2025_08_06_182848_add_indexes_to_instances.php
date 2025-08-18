<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->index('start');
            $table->index('strand_name');
            $table->index('is_on_sale');
            $table->index('event_id');
            $table->index('enabled');
        });

        // You might also want indexes on the events table
        Schema::table('events', function (Blueprint $table) {
            $table->index('show_in_programme');
            $table->index('is_on_sale');
            $table->index('enabled');
            $table->index('published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('instances', function (Blueprint $table) {
            $table->dropIndex(['start']);
            $table->dropIndex(['strand_name']);
            $table->dropIndex(['is_on_sale']);
            $table->dropIndex(['event_id']);
            $table->dropIndex(['enabled']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['show_in_programme']);
            $table->dropIndex(['is_on_sale']);
            $table->dropIndex(['enabled']);
            $table->dropIndex(['published']);
        });
    }
};
