<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookListController;
use App\Http\Controllers\ReadingGoalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'prefix' => 'books',
    'namespace' => 'Books',
], function () {
    Route::get('/', [BookController::class, 'index'])->name('books');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/{book}/add-to-list', [BookController::class, 'addToList'])->name('books.add-to-list');
    Route::post('/do-import', [BookController::class, 'doImport'])->name('books.do-import');
});



Route::resource('book-lists', BookListController::class);

// routes/web.php
Route::resource('reading-goals', ReadingGoalController::class)
    ->only(['index', 'create', 'store', 'edit', 'update','delete']);

require __DIR__.'/auth.php';
