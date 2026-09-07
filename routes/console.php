<?php

use App\Jobs\CacheInstanceAvailability;
use App\Jobs\CachePages;
use App\Jobs\CacheProgramme;
use App\Jobs\FetchCustomerTagData;
use App\Jobs\FetchEventData;
use App\Jobs\FetchFundData;
use App\Jobs\FetchMembershipData;
use App\Jobs\FetchShopData;
use App\Jobs\FetchTicketSubscriptionData;
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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fetch:all', function () {
    dispatch(new FetchEventData);
    dispatch(new FetchMembershipData);
    dispatch(new FetchFundData);
    dispatch(new FetchShopData);
    dispatch(new FetchCustomerTagData);
    dispatch(new FetchTicketSubscriptionData);
    // @todo clear caches.
})->purpose('Fetches all data from Spektrix');

Artisan::command('fetch:tags', function () {
    dispatch(new FetchCustomerTagData);
})->purpose('Fetches customer tags and contact statements from Spektrix');

Artisan::command('fetch:memberships', function () {
    dispatch(new FetchMembershipData);
})->purpose('Fetches membership data from Spektrix');

Artisan::command('fetch:ticket-subscriptions', function () {
    dispatch(new FetchTicketSubscriptionData);
})->purpose('Fetches ticket subscription data from Spektrix');

Artisan::command('fetch:events', function () {
    dispatch(new FetchEventData);
})->purpose('Fetches event data from Spektrix');

Artisan::command('fetch:funds', function () {
    dispatch(new FetchFundData);
})->purpose('Fetches fund data from Spektrix');

Artisan::command('fetch:shop', function () {
    dispatch(new FetchShopData);
})->purpose('Fetches shop data from Spektrix');

// Artisan::command("fetch:instances", function () {
//     dispatch(new \App\Jobs\FetchInstanceData());
// })->purpose("Fetches instance data from Spektrix");

Artisan::command('cache:availability', function () {
    dispatch(new CacheInstanceAvailability);
})->purpose('Caches availability data for all instances');

Artisan::command('cache:programme', function () {
    dispatch(new CacheProgramme);
})->purpose('Cache intensive listings queries');

Artisan::command('cache:pages', function () {
    dispatch(new CachePages);
})->purpose('Warms the full-page response cache for the busiest pages');
