<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('display_menu')->default(false);
        });

        // Preserve the previously hardcoded behaviour: the history pages
        // showed the "jump to" menu based on their slug.
        DB::table('pages')
            ->where('template', 'standard-page')
            ->where('slug', 'like', 'the-history-of%')
            ->update(['display_menu' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('display_menu');
        });
    }
};
