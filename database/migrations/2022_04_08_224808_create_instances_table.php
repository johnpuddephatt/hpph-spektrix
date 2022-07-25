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
            // $table->id();
            $table->string("id")->primary(); // id
            $table->boolean("is_on_sale")->default(false); // isOnSale
            // $table->string('plan_id'); // planId
            // $table->string('price_list_id'); // priceList.id
            $table->string("event_id"); // event.id
            $table
                ->foreign("event_id")
                ->references("id")
                ->on("events");
            $table->dateTimeTz("start"); //start
            // $table->dateTime("start_utc"); //startUtc
            $table->dateTimeTz("start_selling_at_web"); //startSellingAtWeb
            // $table->dateTime("start_selling_at_web_utc"); //startSellingAtWebUtc
            $table->dateTimeTz("stop_selling_at_web"); //stopSellingAtWeb
            // $table->dateTime("stop_selling_at_web_utc"); //stopSellingAtWebUtc
            // $table->string('web_instance_id'); // webInstanceId
            $table->boolean("cancelled")->default(false); // cancelled
            // $table->boolean('has_best_available_overlay'); // hasBestAvailableOverlay
            $table->string("venue")->nullable(); // attribute_Venue
            $table->boolean("audio_described")->default(false); // attribute_AudioDescribed
            $table->boolean("captioned")->default(false); // attribute_Captioned
            $table->boolean("signed_bsl")->default(false); // attribute_SignedBSL
            $table->string("special_event")->nullable(); // attribute_SpecialEvent
            $table->string("accessibility")->nullable(); // attribute_Accessiblity
            $table->string("analogue")->nullable(); // attribute_Analogue
            $table->string("door_time")->nullable(); // attribute_DoorTime
            $table->string("short_playing_with_feature")->nullable(); // attribute_ShortPlayingWithFeature
            $table->string("special_event_into_qa_panel")->nullable(); // attribute_SpecialEventIntoQAPanel
            $table->string("partnership")->nullable(); // attribute_Partnership

            $table->string("season_name")->nullable(); // attribute_Season
            $table
                ->foreign("season_name")
                ->references("name")
                ->on("seasons");

            $table->string("strand_name")->nullable(); // attribute_Strand
            $table
                ->foreign("strand_name")
                ->references("name")
                ->on("strands");
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
