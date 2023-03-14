<?php

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

Route::middleware(["spektrix"])->group(function () {
    Route::get("/", [\App\Http\Controllers\PageController::class, "home"]);

    Route::get("spektrix", function () {
        return null;
    });

    Route::get("brand", function () {
        return view("brand");
    });

    Route::get("checkout", function () {
        return view("checkout");
    });

    Route::get("account", function () {
        return view("account");
    });

    Route::post(
        "file-upload",
        \App\Http\Controllers\UploadController::class
    )->name("file.upload");

    // Route::get("journal", [
    //     \App\Http\Controllers\PostController::class,
    //     "index",
    // ])->name("post.index");

    Route::get("/journal/{post:slug}", [
        \App\Http\Controllers\PostController::class,
        "show",
    ])->name("post.show");

    Route::get("/opportunities/{opportunity:slug}", [
        \App\Http\Controllers\OpportunityController::class,
        "show",
    ])->name("opportunity.show");

    Route::get("/shop/{product:slug}", [
        \App\Http\Controllers\ProductController::class,
        "show",
    ])->name("product.show");

    Route::get(
        "whats-on",
        \App\Http\Controllers\ProgrammeController::class
    )->name("programme");

    Route::get("/films/{event:slug}", [
        \App\Http\Controllers\EventController::class,
        "show",
    ])->name("event.show");

    Route::get("/strands/{strand:slug}", [
        \App\Http\Controllers\StrandController::class,
        "show",
    ])->name("strand.show");

    Route::get("/seasons/{season:slug}", [
        \App\Http\Controllers\SeasonController::class,
        "show",
    ])->name("season.show");

    Route::get("team/{user:slug}", [
        \App\Http\Controllers\UserController::class,
        "show",
    ])->name("user.show");

    Route::get("{page}", [\App\Http\Controllers\PageController::class, "show"])
        ->where("page", "^(?!nova).*")
        ->name("page.show");
});
