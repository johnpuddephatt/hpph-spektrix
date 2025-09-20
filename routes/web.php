<?php

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

Route::middleware(["spektrix"])->group(function () {
    // Route::get("/", function () {
    //     return "<div style='background-color: #f2d13c; height: 100vh; display: flex; align-items: center; justify-content: center'><p style='font-family: Arial; font-size: 1.5em; font-weight: bold'>Coming soon.</p></div>";
    // });
    Route::get("/", [\App\Http\Controllers\PageController::class, "home"]);



    // Required by Spektrix. Do not remove.
    Route::get("spektrix", function () {
        return null;
    });

    foreach (nova_get_setting("redirects") ?? [] as $redirect) {
        if (!$redirect["enabled"]) {
            continue;
        }
        Route::redirect($redirect["from"], $redirect["to"], $redirect["permanent"] ? 301 : 302);
    }


    Route::get("signup-test", [\App\Http\Controllers\SignupController::class, 'form'])->name('signup.form');
    Route::post("signup-test", [\App\Http\Controllers\SignupController::class, 'submit'])->name('signup.submit');

    Route::get("brand", function () {
        return view("brand");
    });

    Route::get("checkout-test", function () {
        return view("checkout-test");
    });

    Route::get("email/{email}", [
        \App\Http\Controllers\EmailController::class,
        "show",
    ])->middleware('doNotCacheResponse')->name("email.show");

    Route::post(
        "file-upload",
        \App\Http\Controllers\UploadController::class
    )->name("file.upload")->middleware('auth');

    Route::get("journal/{post:slug}", [
        \App\Http\Controllers\PostController::class,
        "show",
    ])->name("post.show");

    Route::get("shop/{product:slug}", [
        \App\Http\Controllers\ProductController::class,
        "show",
    ])->name("product.show");

    Route::get("instance/{instance}", function ($instance_id) {
        $instance = Instance::where("id", 'LIKE', $instance_id . '%')->firstOrFail();
        return to_route("event.show", $instance->event)->withFragment('#' . $instance_id);
    });

    Route::get("films/{event:slug}", [
        \App\Http\Controllers\EventController::class,
        "show",
    ])->name("event.show");

    Route::get("strands/{strand:slug}", [
        \App\Http\Controllers\StrandController::class,
        "show",
    ])->name("strand.show");

    Route::get("seasons/{season:slug}", [
        \App\Http\Controllers\SeasonController::class,
        "show",
    ])->name("season.show");

    Route::get("team/{user:slug}", [
        \App\Http\Controllers\UserController::class,
        "show",
    ])->name("user.show");

    Route::get("opportunity/{opportunity:slug}", [
        \App\Http\Controllers\OpportunityController::class,
        "show",
    ])->name("opportunity.show");

    Route::get("{page}", [\App\Http\Controllers\PageController::class, "show"])
        ->where("page", "^(?!nova).*")
        ->name("page.show");
});
