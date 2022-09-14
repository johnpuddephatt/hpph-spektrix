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
        Schema::create("funds", function (Blueprint $table) {
            $table->softDeletes();
            $table->string("id")->primary(); // id
            $table->timestamps();
            $table->boolean("enabled")->default(false);
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("code")->nullable();
            $table->string("default_donation_amount")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("funds");
    }
};
