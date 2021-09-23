<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'categories'], function(){
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/map/{category}', [CategoryController::class, 'map'])->name('category.map');
    // Route::get('create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('show/{category}', [CategoryController::class, 'show'])->name('category.show');
 });
