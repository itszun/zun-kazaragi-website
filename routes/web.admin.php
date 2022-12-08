<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\MenuController;
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

// Route::get('/', function () {
//     return view('admin.index');
// });

// Route::prefix('/menu')->name('menu.')->group(function() {
//     Route::get('/', [MenuController::class, 'index'])->name('index');
//     Route::get('/list', [MenuController::class, 'list'])->name('list');
//     Route::get('/create', [MenuController::class, 'form'])->name('create');
//     Route::get('/{menu?}', [MenuController::class, 'form'])->name('edit');
//     Route::post('/{menu?}', [MenuController::class, 'save'])->name('save');
//     Route::delete('/{menu?}', [MenuController::class, 'destroy'])->name('destroy');
// });

// Route::prefix('/article')->name('article.')->group(function() {
//     Route::get('/', [ArticleController::class, 'index'])->name('index');
//     Route::get('/list', [ArticleController::class, 'list'])->name('list');
//     Route::get('/create', [ArticleController::class, 'form'])->name('create');
//     Route::get('/{article?}', [ArticleController::class, 'form'])->name('edit');
//     Route::post('/{article?}', [ArticleController::class, 'save'])->name('save');
//     Route::delete('/{article?}', [ArticleController::class, 'destroy'])->name('destroy');
// });

// Route::middleware('guest')->group(function () {
//     Route::get('/login', function() {
//         return "UwU";
//     })->name('login');
// });

// Route::middleware('auth')->group(function() {
//     Route::get('/dashboard');
// });
