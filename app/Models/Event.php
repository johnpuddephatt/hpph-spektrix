<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "spektrix_id",
        "duration",
        "is_on_sale",
        "name",
        "instance_dates",
        "first_instance_date_time",
        "last_instance_date_time",
        "archive_film",
        "audio_description",
        "mubigo",
        "non_specialist_film",
        "website",
        "country_of_origin",
        "director",
        "distributor",
        "f_rating",
        "language",
        "original_language_title",
        "strand_name",
        "year_of_production",
        "featuring_stars_1",
        "featuring_stars_2",
        "featuring_stars_3",
        "genre_2",
        "vibe_1",
        "vibe_2",
        "producer",
        "doors",
    ];

    public function instances()
    {
        return $this->hasMany(
            \App\Models\Instance::class,
            "event_id",
            "spektrix_id"
        );
    }

    public function strand()
    {
        return $this->belongsTo(
            \App\Models\Strand::class,
            "strand_name",
            "name"
        );
    }
}
