<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookListController extends Controller
{
    public function index()
    {
        return view('Bookshelves/index');
    }

    public function create()
    {
        return view('Bookshelves/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Bookshelf::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'is_main' => false, // Ensure it's not a main list
        ]);

        return redirect()->route('book-lists.index');
    }

    public function show(Bookshelf $bookshelf)
    {
        if ($bookshelf->user_id !== Auth::id()) {
            abort(403);
        }

        // Paginate the books relationship with sorting
        $books = $bookshelf->books();

        return view('Bookshelves/books', [
            'books' => $books,
            'bookshelf' => $bookshelf,
        ]);
    }
    public function edit(Bookshelf $bookshelf)
    {
        if ($bookshelf->user_id !== Auth::id()) {
            abort(403);
        }
        // Ensure the user owns the book list

        return view('Bookshelves.edit', [
            'bookshelf' => $bookshelf,
        ]);
    }

    public function update(Request $request, Bookshelf $bookList): RedirectResponse
    {
        // Ensure the user owns the book list
        if ($bookList->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bookList->update([
            'name' => $request->name,
        ]);

        return redirect()->route('book-lists.index');
    }

    public function delete(Bookshelf $bookList): RedirectResponse
    {
        // Ensure the user owns the book list
        if ($bookList->user_id !== Auth::id()) {
            abort(403);
        }

        $bookList->delete();

        return redirect()->route('book-lists.index');
    }
}
