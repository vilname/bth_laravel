<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::post('/', [ProductController::class, 'store'])->name('product.store')->middleware('product');
Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
