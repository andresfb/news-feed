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
    echo 'not implemented yet';
})->name('grouped');

Route::get('/provider', static function () {
    echo 'not implemented yet';
})->name('provider');

Route::get('/archive', static function () {
    echo 'not implemented yet';
})->name('archive');

Route::get('/track/{article}', TrackController::class)->name('track');

