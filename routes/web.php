<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/laporanbarangmasuk', [LaporanController::class, 'laporanbarangmasuk'])->name('Laporan.laporanbarangmasuk');
Route::get('/laporanbarangmasuk/print', [LaporanController::class, 'printbarangmasuk'])->name('Laporan.printlaporanbarangmasuk');

Route::get('/laporanbarangkeluar', [LaporanController::class, 'laporanbarangkeluar'])->name('Laporan.laporanbarangkeluar');
