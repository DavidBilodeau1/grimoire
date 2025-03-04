<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class BookListController extends Controller
{
    public function index(): Response
    {
        $bookLists = Bookshelf::where('user_id', Auth::id())->get();

        return Inertia::render('BookLists/Index', [
            'bookLists' => $bookLists,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('BookLists/Create');
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

    public function show(Bookshelf $bookList): Response
    {
        if ($bookList->user_id !== Auth::id()) {
            abort(403);
        }

        $sortBy = request()->input('sort_by', 'title');
        $sortDirection = request()->input('sort_direction', 'asc');

        // Paginate the books relationship with sorting
        $books = $bookList->books()->orderBy($sortBy, $sortDirection)->paginate(10);

        return Inertia::render('BookLists/Show', [
            'books' => $books,
            'bookList' => $bookList,
        ]);
    }
    public function edit(Bookshelf $bookList): Response
    {
        // Ensure the user owns the book list
        if ($bookList->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('BookLists/Edit', [
            'bookList' => $bookList,
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

    public function destroy(Bookshelf $bookList): RedirectResponse
    {
        // Ensure the user owns the book list
        if ($bookList->user_id !== Auth::id()) {
            abort(403);
        }

        $bookList->delete();

        return redirect()->route('book-lists.index');
    }
}
