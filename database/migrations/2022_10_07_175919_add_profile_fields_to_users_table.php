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
        Schema::table("users", function (Blueprint $table) {
            $table->boolean("show_in_directory")->default(false);
            $table->boolean("enable_login")->default(false);
            $table->string("role_title")->nullable();
            $table->text("role_description")->nullable();
            $table->json("extras")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("user", function (Blueprint $table) {
            //
        });
    }
};
