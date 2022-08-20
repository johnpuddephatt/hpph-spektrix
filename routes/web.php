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

Route::get("/", [\App\Http\Controllers\PageController::class, "home"]);

Route::get("spektrix", function () {
    return null;
});

Route::get("brand", function () {
    return view("brand");
});

Route::get("/journal/{post:slug}", [
    \App\Http\Controllers\PostController::class,
    "show",
])->name("post.show");

Route::get("whats-on", \App\Http\Controllers\ProgrammeController::class)->name(
    "programme"
);

Route::get("/films/{event:slug}", [
    \App\Http\Controllers\EventController::class,
    "show",
])->name("event.show");

Route::get("/strands/{strand:slug}", [
    \App\Http\Controllers\StrandController::class,
    "show",
])->name("strand.show");

Route::get("/{page1}/{page2?}/{page3?}", [
    \App\Http\Controllers\PageController::class,
    "show",
])->where("page1", "^(?!nova).*");

Route::middleware("auth")->group(function () {
    Route::mediaLibrary();
});
