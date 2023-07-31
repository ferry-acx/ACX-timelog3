<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('/admin')->group(function () {

    Route::get('/', function(){
        return view('admin.dashboard');
    })->name('admin.index');
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
})->middleware('admin');

Route::prefix('/staff')->group(function (){

    Route::get('/', function(){
        return view('staff.dashboard');
    })->name('staff.index');
    Route::get('/dashboard', function(){
        return view('staff.dashboard');
    })->name('staff.dashboard');
})->middleware('staff');

