<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("memberships", function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean("enabled")->default(false);
            $table->boolean("show_by_booking_path")->default(false);
            $table->string("id", 255);
            $table->string("name", 150);
            $table->string("description", 400)->nullable();
            $table->json("benefits")->default(new Expression("(JSON_ARRAY())"));
            $table->string("logo")->nullable();
            $table->string("price", 30);
            $table->string("renewal_price", 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("memberships");
    }
}
