<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookListController;
use App\Http\Controllers\ReadingGoalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return view('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'prefix' => 'books',
], function () {
    Route::get('/', [BookController::class, 'index'])->name('books');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/{book}/add-to-list', [BookController::class, 'addToList'])->name('books.add-to-list');
    Route::post('/do-import', [BookController::class, 'doImport'])->name('books.do-import');
});

Route::resource('bookshelves', BookListController::class)
    ->only(['index', 'create', 'show', 'store', 'edit', 'update','delete']);

Route::resource('reading-goals', ReadingGoalController::class)
    ->only(['index', 'create', 'store', 'edit', 'update','delete']);

require __DIR__.'/auth.php';
