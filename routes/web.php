<?php

use App\Http\Controllers\AskingController;
use App\Http\Controllers\ProductController;
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

Route::get('/form-sample', function () {
    return view('form-sample');
});

Route::get('/quiz', function () {
    return view('quiz');
});

Route::get('/askings', [AskingController::class, 'index']);

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');


Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/search-results', [ProductController::class, 'searchProducts'])->name('products.searchProducts');
