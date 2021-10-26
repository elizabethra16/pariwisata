<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoAddressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('google-map')->group(function () {
    Route::get('/',[App\Http\Controllers\GoogleMapController::class ,'index'])->name('google.map.index');
    Route::post('/post',[App\Http\Controllers\GoogleMapController::class,'store'])->name('google.map.store');

});