<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdOfferController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('ad_offers', AdOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth:companies');

Route::resource('ad_offers', AdOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth:companies,users');

require __DIR__ . '/auth.php';
