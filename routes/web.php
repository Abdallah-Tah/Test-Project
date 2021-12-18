<?php

use App\Http\Controllers\ClosureController;
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

Route::get('/', [ClosureController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->namespace('Store')
    ->prefix('store')
    ->name('store.')
    ->group(__DIR__ . '/Store/web.php');

Route::namespace('Store')
    ->prefix('sign-in')
    ->name('public.')
    ->group(__DIR__ . '/Store/Location/public.php');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    // ----------------------------- Shoopper ------------------------------//
    Route::post('/store/queue', [\App\Http\Controllers\Shopper\ShopperQueueController::class, 'index']);
    Route::post('/create-shopper', [\App\Http\Controllers\Shopper\ShopperQueueController::class, 'createShopper']);
    Route::put('/mark.checkout/{id}', [\App\Http\Controllers\Shopper\ShopperQueueController::class, 'checkOutButton'])->name('checkout.button'); // this is brother, where is error

    // ----------------------------- Location ------------------------------//
    Route::put('/edit-limit/{id}', [\App\Http\Controllers\Store\Location\LocationController::class, 'updateLimit'])->name('shopper.limit');

});
