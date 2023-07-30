<?php

use App\Emuns\PageName;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\GroupedController;
use App\Http\Controllers\MarkArticleReadController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RefreshController;
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

Route::get('/', [FrontPageController::class, 'index'])->name(PageName::AllNews->value);

Route::get('/grouped', GroupedController::class)->name(PageName::Grouped->value);

Route::get('/provider/{provider}', ProviderController::class)->name(PageName::Provider->value);

Route::get('/archive', static function () {
    // TODO: implement archive view
    // TODO: add Meilisearch
    // TODO: in the archive controller add a search engine
    // TODO: in the archive controller add load all articles in descending order and paginated (50 per page).
    // TODO: in the archive controller add a filters by provider, feed, and date range.

    echo 'not implemented yet';
})->name(PageName::Archive->value);

Route::controller(MarkArticleReadController::class)->group(function () {
    Route::post('/mark-read/{article}/update', 'update')->name('article.update');
    Route::delete('/mark-read/{article}/delete', 'delete')->name('article.delete');
});

Route::get('/track/{article}', TrackController::class)->name('track');
Route::post('/refresh', RefreshController::class)->name('refresh');
