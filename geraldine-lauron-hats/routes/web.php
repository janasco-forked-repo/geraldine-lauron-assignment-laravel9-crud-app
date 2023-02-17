<?php

use App\Http\Controllers\HatController;
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


Route::get('/', [HatController::class, 'index']);
Route::post('/create', [HatController::class, 'create'])->name('create');
Route::get('/read', [HatController::class, 'read'])->name('read');
Route::post('/update', [HatController::class, 'update'])->name('update');
Route::delete('/delete', [HatController::class, 'delete'])->name('delete');
Route::get('/edit', [HatController::class, 'edit'])->name('edit');
Route::get('/view', [HatController::class, 'view'])->name('view');
