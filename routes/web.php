<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkDataController;
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


Route::get('/bulkdata', [BulkDataController::class, 'index'])->name('bulkdata.index');
Route::get('/bulkdata/import', [BulkDataController::class, 'importPage'])->name('bulkdata.import.page');
Route::post('/bulkdata/import', [BulkDataController::class, 'imported'])->name('bulkdata.import');
Route::post('/bulkdata/upload', [BulkDataController::class, 'upload'])->name('bulkdata.upload');
Route::put('/bulkdata/{id}', [BulkDataController::class, 'update'])->name('bulkdata.update');

// Product routes
Route::get('/products/import', [ProductController::class, 'importPage'])->name('products.import.page');
Route::post('/products/import', [ProductController::class, 'product'])->name('products.import');
//update route for product
Route::post('/products/update', [ProductController::class, 'updateProducts'])->name('products.update');








