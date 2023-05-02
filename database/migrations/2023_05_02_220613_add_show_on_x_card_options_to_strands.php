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
        Schema::table("strands", function (Blueprint $table) {
            $table->boolean("show_on_instance_card")->default(true);
            $table->boolean("show_on_event_card")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("strands", function (Blueprint $table) {
            //
        });
    }
};
