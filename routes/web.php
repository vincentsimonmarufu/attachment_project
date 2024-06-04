<?php

use App\Http\Controllers\FoodCollectionController;
use App\Http\Controllers\JobcardsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return 123;
});

Auth::routes();

// Public routes files
Route::group(['middleware' => ['web', 'activity']], function () {

    // unauthorised
    Route::get('/unauthorized', 'App\Http\Controllers\HomeController@unauthorized');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
