<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("events", function (Blueprint $table) {
            $table->id();
            $table->string("spektrix_id")->unique(); // id
            // $table->text("description")->nullable(); // description
            // $table->text("html_description")->nullable(); // htmlDescription
            $table->integer("duration")->nullable(); // duration
            // $table->string("image_url")->nullable(); // imageUrl
            $table->boolean("is_on_sale")->default(false); //isOnSale
            $table->string("name")->nullable(); // name
            $table->string("instance_dates")->nullable(); // instanceDates
            // $table->string("thumbnail_url")->nullable(); // thumbnailUrl
            // $table->string("web_event_id")->nullable(); // webEventId
            $table->dateTime("first_instance_date_time")->nullable(); //firstInstanceDateTime
            $table->dateTime("last_instance_date_time")->nullable(); //lastInstanceDateTime
            $table->boolean("archive_film")->default(false); // attribute_ArchiveFilm
            $table->boolean("audio_description")->default(false); // attribute_AudioDescription
            // $table->boolean("dont_report_to_comscore"); // attribute_DontReportToComscore
            $table->boolean("mubigo")->default(false); // attribute_MUBIGO
            $table->boolean("non_specialist_film")->default(false); // attribute_NonSpecialistFilm
            // $table->string("theatre_website_genre")->nullable(); // attribute_TheatreWebsiteGenre
            $table->string("website")->nullable(); // attribute_Website
            $table->string("country_of_origin")->nullable(); // attribute_CountryOfOrigin
            $table->string("director")->nullable(); // attribute_Director
            $table->string("distributor")->nullable(); // attribute_Distributor
            $table->string("f_rating")->nullable(); // attribute_FRating
            $table->string("language")->nullable(); // attribute_Language
            $table->string("original_language_title")->nullable(); // attribute_OriginalLanguageTitle
            $table->string("strand_name")->nullable(); // attribute_Strand
            $table
                ->foreign("strand_name")
                ->references("name")
                ->on("strands");
            $table->string("year_of_production")->nullable(); // attribute_YearOfProduction
            $table->string("featuring_stars_1")->nullable(); // attribute_FeaturingStars1
            $table->string("featuring_stars_2")->nullable(); // attribute_FeaturingStars2
            $table->string("featuring_stars_3")->nullable(); // attribute_FeaturingStars3
            $table->string("genre_2")->nullable(); // attribute_Genre2
            $table->string("vibe_1")->nullable(); // attribute_Vibe1
            $table->string("vibe_2")->nullable(); // attribute_Vibe2
            // $table->string("live_or_film")->nullable(); // attribute_LiveOrFilm
            // $table->string("FMS_cost_centre")->nullable(); // attribute_FMSCostCentre
            // $table->string("FMS_vote_code")->nullable(); // attribute_FMSVoteCode
            // $table->string("producer")->nullable(); // attribute_Producer
            // $table->string("audience_agency_field")->nullable(); // attribute_AudienceAgencyField
            // $table->string("doors")->nullable(); // attribute_Doors
            // $table->string("theatre_website_commission")->nullable(); // attribute_TheatreWebsiteCommission
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("events");
    }
}
