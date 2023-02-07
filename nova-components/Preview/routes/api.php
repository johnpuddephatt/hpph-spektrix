<?php

use Illuminate\Support\Facades\Route;
use Jdp\Preview\Http\Controllers\ViewController;

Route::post("view", ViewController::class)->name("view");
