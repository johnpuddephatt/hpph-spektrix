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

Route::get("/", function () {
    return view("welcome");
});

Route::get("/posts/{post:slug}", [
    \App\Http\Controllers\PostController::class,
    "show",
]);

Route::get("/{page_1}/{page_2?}/{page_3?}/{page_4?}", [
    \App\Http\Controllers\PageController::class,
    "show",
])->where("page_1", "^(?!nova).*");
