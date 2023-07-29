<?php

use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\GroupedController;
use App\Http\Controllers\ProviderController;
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

Route::get('/grouped', GroupedController::class)->name('grouped');

Route::get('/provider/{provider}', ProviderController::class)->name('provider');

Route::get('/archive', static function () {
    // TODO: implement archive view
    // TODO: add Meilisearch
    // TODO: in the archive controller add a search engine
    // TODO: in the archive controller add load all articles in descending order and paginated (50 per page).
    // TODO: in the archive controller add a filters by provider, feed, and date range.

    echo 'not implemented yet';
})->name('archive');

Route::get('/track/{article}', TrackController::class)->name('track');

