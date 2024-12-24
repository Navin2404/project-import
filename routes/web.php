<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkDataController;

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
Route::get('/bulkdata/import', [BulkDataController::class, 'importPage'])->name('bulkdata.import.page'); // Route to show import form
Route::post('/bulkdata/import', [BulkDataController::class, 'imported'])->name('bulkdata.import'); // Route to handle the import form
Route::post('/bulkdata/upload', [BulkDataController::class, 'upload'])->name('bulkdata.upload');
Route::put('/bulkdata/{id}', [BulkDataController::class, 'update'])->name('bulkdata.update');





