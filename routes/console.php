<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command("inspire", function () {
    $this->comment(Inspiring::quote());
})->purpose("Display an inspiring quote");

Artisan::command("fetch:all", function () {
    dispatch(new \App\Jobs\FetchEventData());
    dispatch(new \App\Jobs\FetchMembershipData());
    dispatch(new \App\Jobs\FetchFundData());
    dispatch(new \App\Jobs\FetchShopData());
    // @todo clear caches.
})->purpose("Fetches all data from Spektrix");

Artisan::command("fetch:memberships", function () {
    dispatch(new \App\Jobs\FetchMembershipData());
})->purpose("Fetches membership data from Spektrix");

Artisan::command("fetch:events", function () {
    dispatch(new \App\Jobs\FetchEventData());
})->purpose("Fetches event data from Spektrix");

Artisan::command("fetch:funds", function () {
    dispatch(new \App\Jobs\FetchFundData());
})->purpose("Fetches fund data from Spektrix");

Artisan::command("fetch:shop", function () {
    dispatch(new \App\Jobs\FetchShopData());
})->purpose("Fetches shop data from Spektrix");

// Artisan::command("fetch:instances", function () {
//     dispatch(new \App\Jobs\FetchInstanceData());
// })->purpose("Fetches instance data from Spektrix");

Artisan::command("cache:availability", function () {
    dispatch(new \App\Jobs\CacheInstanceAvailability());
})->purpose("Caches availability data for all instances");
