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
    Route::get("/", function () {
        return "<div style='background-color: #f2d13c; height: 100vh; display: flex; align-items: center; justify-content: center'><p style='font-family: Arial; font-size: 1.5em; font-weight: bold'>Coming soon.</p></div>";
    });
    Route::get("/home", [\App\Http\Controllers\PageController::class, "home"]);

    // Required by Spektrix. Do not remove.
    Route::get("spektrix", function () {
        return null;
    });

    Route::get("brand", function () {
        return view("brand");
    });

    Route::post(
        "file-upload",
        \App\Http\Controllers\UploadController::class
    )->name("file.upload");

    Route::get("journal/{post:slug}", [
        \App\Http\Controllers\PostController::class,
        "show",
    ])->name("post.show");

    Route::get("shop/{product:slug}", [
        \App\Http\Controllers\ProductController::class,
        "show",
    ])->name("product.show");

    Route::get(
        "whats-on",
        \App\Http\Controllers\ProgrammeController::class
    )->name("programme");

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
