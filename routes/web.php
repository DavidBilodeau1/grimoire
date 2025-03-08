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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'prefix' => 'books',
], function () {
    Route::get('/', [BookController::class, 'index'])->name('books');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/add-to-bookshelf', [BookController::class, 'addToBookshelf'])->name('books.add-to-bookshelf');
    Route::post('/do-import', [BookController::class, 'doImport'])->name('books.do-import');
    // routes/web.php

});

Route::get('/api-show', function () {
    $book = session()->get('selectedBook');
    return view('Books.api-show', ['book' => $book]);
})->name('books.api-show');

Route::post('/api-add-to-bookshelf', [BookController::class, 'apiAddToBookshelf'])->name('books.api-add-to-bookshelf');

Route::resource('bookshelves', BookListController::class)
    ->only(['index', 'create', 'show', 'store', 'edit', 'update','delete']);

Route::resource('reading-goals', ReadingGoalController::class)
    ->only(['index', 'create', 'store', 'edit', 'update','delete']);

Route::get('/{reading_goal}/add', [ReadingGoalController::class, 'addBooks'])->name('reading-goals.add-books');

require __DIR__.'/auth.php';
