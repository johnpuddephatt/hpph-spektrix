<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("instances", function (Blueprint $table) {
            $table->id();
            $table->string("spektrix_id")->unique(); // id
            $table->boolean("is_on_sale")->default(false); // isOnSale
            // $table->string('plan_id'); // planId
            // $table->string('price_list_id'); // priceList.id
            $table->string("event_id"); // event.id
            $table
                ->foreign("event_id")
                ->references("spektrix_id")
                ->on("events");
            $table->dateTimeTz("start"); //start
            // $table->dateTime("start_utc"); //startUtc
            $table->dateTimeTz("start_selling_at_web"); //startSellingAtWeb
            // $table->dateTime("start_selling_at_web_utc"); //startSellingAtWebUtc
            $table->dateTimeTz("stop_selling_at_web"); //stopSellingAtWeb
            // $table->dateTime("stop_selling_at_web_utc"); //stopSellingAtWebUtc
            // $table->string('web_instance_id'); // webInstanceId
            $table->boolean("cancelled")->default(false); // cancelled
            // $table->boolean('best_available_overlay'); // hasBestAvailableOverlay
            $table->string("analogue")->nullable(); // attribute_Analogue
            $table->boolean("captioned")->default(false); // attribute_Captioned
            $table->string("special_event")->nullable(); // attribute_SpecialEvent
            $table->boolean("short_film_with_feature")->default(false); // attribute_ShortFilmWithFeature
            $table->boolean("audio_described")->default(false); // attribute_AudioDescribed
            $table->string("season_name")->nullable(); // attribute_Season
            $table
                ->foreign("season_name")
                ->references("name")
                ->on("seasons");
            $table->string("target_audience")->nullable(); // attribute_TargetAudience1
            $table->string("target_audience_2")->nullable(); //attribute_TargetAudience2
            $table->boolean("signed_bsl")->default(false); // attribute_SignedBSL
            $table->boolean("relaxed_performance")->default(false); // attribute_RelaxedPerformance
            // $table->boolean('press_night'); // attribute_PressNight
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("instances");
    }
}
