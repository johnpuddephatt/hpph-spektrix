<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

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
            $table->string("id")->primary(); // id
            $table->softDeletes();

            $table->string("slug")->nullable();
            $table->text("description")->nullable();
            $table->text("long_description")->nullable();
            $table->json("reviews")->default(new Expression("(JSON_ARRAY())"));
            $table
                ->json("why_watch")
                ->default(new Expression("(JSON_ARRAY())"));
            $table->string("trailer")->nullable();

            $table->boolean("enabled")->default(false);
            $table->boolean("published")->default(false);

            $table->integer("duration")->nullable(); // duration
            $table->boolean("is_on_sale")->default(false); //isOnSale
            $table->string("name")->nullable(); // name
            $table->string("instance_dates")->nullable(); // instanceDates
            $table->dateTime("first_instance_date_time")->nullable(); //firstInstanceDateTime
            $table->dateTime("last_instance_date_time")->nullable(); //lastInstanceDateTime
            $table->boolean("alternative_content")->default(false); // attribute_AlternativeContent
            $table
                ->boolean("archive_film")
                ->default(false)
                ->nullable(); // attribute_ArchiveFilm
            $table->boolean("audio_description")->default(false); // attribute_AudioDescription
            $table->boolean("mubigo")->default(false); // attribute_MUBIGO
            $table->boolean("non_specialist_film")->default(false); // attribute_NonSpecialistFilm
            $table->string("country_of_origin")->nullable(); // attribute_CountryOfOrigin
            $table->string("director")->nullable(); // attribute_Director
            $table->string("distributor")->nullable(); // attribute_Distributor
            $table->string("f_rating")->nullable(); // attribute_FRating
            $table->string("language")->nullable(); // attribute_Language
            $table->string("original_language_title")->nullable(); // attribute_OriginalLanguageTitle
            $table->boolean("strobe_light_warning")->default(false); // attribute_StrobeLightWarning
            $table->string("year_of_production")->nullable(); // attribute_YearOfProduction
            $table->string("featuring_stars")->nullable(); // attribute_FeaturingStars1 attribute_FeaturingStars2 attribute_FeaturingStars3
            $table->string("genres")->nullable(); // attribute_Genre1 attribute_Genre2 attribute_Genre3
            $table->string("vibes")->nullable(); // attribute_Vibe1 attribute_Vibe2
            $table->boolean("members_offer_available")->default(false); //attribute_MembersOfferAvailable
            $table->string("certificate_age_guidance")->nullable(); // attribute_CertificateAgeGuidance

            $table->string("live_or_film")->nullable(); // attribute_LiveOrFilm
            // $table->string("image_url")->nullable(); // imageUrl
            // $table->text("description")->nullable(); // description
            // $table->text("html_description")->nullable(); // htmlDescription
            // $table->string("thumbnail_url")->nullable(); // thumbnailUrl
            // $table->string("web_event_id")->nullable(); // webEventId
            // $table->string("website")->nullable(); // attribute_Website
            // $table->boolean("dont_report_to_comscore"); // attribute_DontReportToComscore
            // $table->string("theatre_website_commission")->nullable(); // attribute_TheatreWebsiteCommission
            // $table->string("theatre_website_genre")->nullable(); // attribute_TheatreWebsiteGenre
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
