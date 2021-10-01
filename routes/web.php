<?php

use App\Http\Controllers\CountriesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/countries-list', [CountriesController::class, 'index'])->name('countries.list');
Route::post('/add-country', [CountriesController::class, 'addCountry'])->name('add.country');
Route::get('/get-countries-lists', [CountriesController::class, 'getCountriesLists'])->name('get.countries.lists');
Route::post('/get-countries-details', [CountriesController::class, 'getCountriesDetails'])->name('get.countries.details');
Route::post('/update-country-details', [CountriesController::class, 'updateCountryDetails'])->name('update.country.details');
