<?php

use App\Http\Controllers\ListingController;
use App\Models\Listing;
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

Route::get('/',[App\Http\Controllers\ListingController::class,'index'])->name('index');
Route::get('/listing/create',[App\Http\Controllers\ListingController::class,'create'])->name('create')->middleware('auth');
Route::post('/listing',[App\Http\Controllers\ListingController::class,'store'])->name('store');
Route::get('/listing/{listing}/edit',[App\Http\Controllers\ListingController::class,'edit'])->name('edit')->middleware('auth');
Route::put('/listing/{listing}',[App\Http\Controllers\ListingController::class,'update'])->name('update');
Route::delete('/listing/{listing}',[App\Http\Controllers\ListingController::class,'destroy'])->name('delete')->middleware('auth');

Route::get('/listing/{listing}',[App\Http\Controllers\ListingController::class,'show'])->name('show');
// Manage Listings
Route::get('/listings/manage', [App\Http\Controllers\ListingController::class, 'manage'])->middleware('auth');


//users
Route::get('/register',[App\Http\Controllers\UserController::class,'register'])->name('register')->middleware('guest');
Route::get('/login',[App\Http\Controllers\UserController::class,'login'])->name('login');
Route::post('/users',[App\Http\Controllers\UserController::class,'store'])->name('store');
Route::post('/logout',[App\Http\Controllers\UserController::class,'logout'])->name('logout');

Route::post('/users/authenticate',[App\Http\Controllers\UserController::class, 'authenticate']);







