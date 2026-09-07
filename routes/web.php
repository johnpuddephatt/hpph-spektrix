<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StrandController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Models\Instance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// \Livewire\Livewire::routes();

// Outside the spektrix middleware group: the sitemap is built from local models
// only, so it should still serve if the Spektrix settings are missing.
Route::get('sitemap.xml', SitemapController::class)->name(
    'sitemap'
);

Route::middleware(['spektrix'])->group(function () {
    // Route::get("/", function () {
    //     return "<div style='background-color: #f2d13c; height: 100vh; display: flex; align-items: center; justify-content: center'><p style='font-family: Arial; font-size: 1.5em; font-weight: bold'>Coming soon.</p></div>";
    // });
    Route::get('/', [PageController::class, 'home']);

    // Required by Spektrix. Do not remove.
    Route::get('spektrix', function () {
        return null;
    });

    foreach (nova_get_setting('redirects') ?? [] as $redirect) {
        if (! $redirect['enabled']) {
            continue;
        }
        Route::redirect($redirect['from'], $redirect['to'], $redirect['permanent'] ? 301 : 302);
    }

    // Submission is handled by the Livewire component, which is also what makes
    // this safe to cache: it holds its own success state rather than relying on a
    // redirect and a session flash.
    Route::get('signup-test', [SignupController::class, 'form'])
        ->name('signup.form');

    Route::get('brand', function () {
        return view('brand');
    });

    Route::get('checkout-test', function () {
        return view('checkout-test');
    });

    Route::get('email/{email}', [
        EmailController::class,
        'show',
    ])->middleware('doNotCacheResponse')->name('email.show');

    Route::post(
        'file-upload',
        UploadController::class
    )->name('file.upload')->middleware('auth');

    Route::get('journal/{post:slug}', [
        PostController::class,
        'show',
    ])->name('post.show');

    Route::get('shop/{product:slug}', [
        ProductController::class,
        'show',
    ])->name('product.show');

    Route::get('instance/{instance}', function ($instance_id) {
        $instance = Instance::where('id', 'LIKE', $instance_id.'%')->firstOrFail();

        return to_route('event.show', $instance->event)->withFragment('#'.$instance_id);
    });

    Route::get('films/{event:slug}', [
        EventController::class,
        'show',
    ])->name('event.show');

    Route::get('strands/{strand:slug}', [
        StrandController::class,
        'show',
    ])->name('strand.show');

    Route::get('seasons/{season:slug}', [
        SeasonController::class,
        'show',
    ])->name('season.show');

    Route::get('team/{user:slug}', [
        UserController::class,
        'show',
    ])->name('user.show');

    Route::get('opportunity/{opportunity:slug}', [
        OpportunityController::class,
        'show',
    ])->name('opportunity.show');

    Route::get('{page}', [PageController::class, 'show'])
        ->where('page', '^(?!nova).*')
        ->name('page.show');
});
