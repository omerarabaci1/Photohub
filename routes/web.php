<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return redirect('/photos');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('photos', PhotoController::class);
});
Route::middleware('auth')->group(function () {
    Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
    Route::delete('/photos/{photo}/unlike', [PhotoController::class, 'unlike'])->name('photos.unlike');
});
Route::middleware('auth')->group(function () {
    Route::post('/photos/{photo}/comment', [PhotoController::class, 'storeComment'])->name('photos.comment');
});


