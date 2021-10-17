<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ParameterController;

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
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'categories'], function(){
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    Route::get('map/{category}', [CategoryController::class, 'map'])->name('category.map');
    Route::get('create/{id}', [CategoryController::class, 'create'])->name('category.create');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('show/{category}', [CategoryController::class, 'show'])->name('category.show');
 });

 
Route::group(['prefix' => 'parameters'], function(){
    Route::get('', [ParameterController::class, 'index'])->name('parameter.index');
    Route::get('/map/{parameter}', [ParameterController::class, 'map'])->name('parameter.map');
    Route::get('create', [ParameterController::class, 'create'])->name('parameter.create');
    Route::post('store', [ParameterController::class, 'store'])->name('parameter.store');
    Route::get('edit/{parameter}', [ParameterController::class, 'edit'])->name('parameter.edit');
    Route::post('update/{parameter}', [ParameterController::class, 'update'])->name('parameter.update');
    Route::post('delete/{parameter}', [ParameterController::class, 'destroy'])->name('parameter.destroy');
    Route::get('show/{parameter}', [ParameterController::class, 'show'])->name('parameter.show');
 });

 Route::group(['prefix' => 'items'], function(){
    Route::get('', [ItemController::class, 'index'])->name('item.index');
    Route::get('map/{item}', [ItemController::class, 'map'])->name('item.map');
    Route::get('create/{category}', [ItemController::class, 'create'])->name('item.create');
    Route::post('store', [ItemController::class, 'store'])->name('item.store');
    Route::get('edit/{item}', [ItemController::class, 'edit'])->name('item.edit');
    Route::post('update/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::post('delete/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::get('show/{id}', [ItemController::class, 'show'])->name('item.show');
    Route::post('softDelete/{item}', [ItemController::class, 'softDelete'])->name('item.softDelete');
 });

 Route::post('searchBar', [ItemController::class, 'searchBar'])->name('item.searchBar');
 Route::post('heart', [ItemController::class, 'heart'])->name('item.heart');
 Route::get('heart2', [ItemController::class, 'heart2'])->name('item.heart2');