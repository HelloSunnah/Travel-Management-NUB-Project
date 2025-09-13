<?php

use App\Http\Controllers\DestinationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\HotelRoomsController;
use App\Http\Controllers\FoodsController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\packageFoodsController;
use App\Http\Controllers\TransportsController;
use App\Http\Controllers\PackageTransportController;
use App\Http\Controllers\OtherCostController;
use App\Http\Controllers\PackageHotelController;



    Route::get('/', [FrontendController::class, 'index']);


Route::get('/dashboard', function () {
    return view('AdminPanel.dashboard');
})->middleware(['auth', 'verified'])->name('master');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('packages', PackagesController::class);
    Route::resource('destinations', DestinationsController::class);
    Route::resource('hotels', HotelsController::class);
    Route::resource('hotel-rooms', HotelRoomsController::class);
    Route::resource('package-hotels', PackageHotelController::class);
    Route::resource('foods', FoodsController::class);
    Route::resource('package-foods', packageFoodsController::class);
    Route::resource('transports', TransportsController::class);
    Route::resource('package-transports', PackageTransportController::class);
    Route::resource('other-costs', OtherCostController::class);
// Ajax
Route::get('/destinations/{id}/hotels', [PackagesController::class, 'getHotels']);
Route::get('/hotels/{id}/rooms', [PackagesController::class, 'getRooms']);
Route::get('/destinations/{id}/foods', [PackagesController::class, 'getFoods']);

});

require __DIR__ . '/auth.php';
