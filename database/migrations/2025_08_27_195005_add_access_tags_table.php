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
        Schema::create("access_tags", function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('abbreviation')->unique();
            $table->index('abbreviation');
            $table->string('read_more_link')->nullable();
            $table->string('description')->nullable();
            $table->string('booking_warning')->nullable();
            $table->string('slug')->nullable();
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
