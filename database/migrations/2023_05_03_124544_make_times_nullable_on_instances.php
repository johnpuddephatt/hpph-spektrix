<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("instances", function (Blueprint $table) {
            $table
                ->string("start")
                ->nullable()
                ->default(null)
                ->change();
            $table
                ->string("start_selling_at_web")
                ->nullable()
                ->default(null)
                ->change();
            $table
                ->string("stop_selling_at_web")
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
