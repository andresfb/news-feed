<?php

use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontPageController::class, 'index'])->name('frontpage');

Route::get('/grouped', static function () {
    // TODO: implement grouped view
    echo 'not implemented yet';
})->name('grouped');

Route::get('/provider/{provider}', static function () {
    // TODO: implement provider view
    echo 'not implemented yet';
})->name('provider');

Route::get('/archive', static function () {
    // TODO: implement archive view
    echo 'not implemented yet';
})->name('archive');

Route::get('/track/{article}', TrackController::class)->name('track');

