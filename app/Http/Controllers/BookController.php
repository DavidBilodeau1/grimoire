<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBookshelf;
use App\Models\Bookshelf;
use App\Models\BookUser;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;

class BookController extends Controller
{

    public function index(Request $request)
    {
        return view('Books/index');
    }


    public function show(Book $book)
    {
        $bookLists = Bookshelf::where('user_id', Auth::id())->get();

        // Fetch the user-specific information for this book
        $userBookInfo = BookUser::where('user_id', Auth::id())->where('book_id', $book->id)->first();

        return view('Books/Show', [
            'book' => $book,
            'bookLists' => $bookLists,
            'userBookInfo' => $userBookInfo
        ]);
    }

    public function addToBookshelf()
    {
        $bookShelves = Bookshelf::where('user_id', Auth::id())->get();
        return view('Books/add-to-bookshelf', [
            'bookshelves' => $bookShelves,
        ]);
    }

    public static function apiAddToBookshelf(string $data, $bookshelfId)
    {
        try {
            $bookData = json_decode(base64_decode($data), true);

            // Find or create the book
            $book = new Book();
            $book->title = $bookData['title'];
            $book->author = $bookData['authors'];
            $book->cover_image = $bookData['cover_image'];
            $book->description = $bookData['description'];
            $book->isbn = $bookData['isbn'];
            $book->publisher = $bookData['publisher'];
            $book->number_of_pages = $bookData['page_count'];
            $book->save();

            $nextPosition = $book->bookshelves()->where('bookshelf_id', $bookshelfId)->max('position') + 1;

            $book->bookshelves()->attach($bookshelfId, ['position' => $nextPosition]);

            return response()->json(['message' => 'Book added to bookshelf']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }

    public static function doImport($file)
    {
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Set the header offset to 0 if the first row contains headers

        $header = $csv->getHeader(); // Get the header row
        $records = $csv->getRecords(); // Get all the records

        foreach ($records as $record) {
            $existingBook = Book::where(function ($query) use ($record) {
                $query->where('title', $record['Title'])
                    ->orWhere('author', $record['Author'])
                    ->orWhere('isbn', $record['ISBN']);
            })->first();

            if ($existingBook) {
                // TODO: update book entry?
                $existingUserBookData = $existingBook->users()->where('user_id', Auth::id())->first();

                if ($existingUserBookData) {
                    // TODO: update user specific book entry
                    continue;
                }
            }
            // Map the CSV columns to your Book model fields
            $bookData = [
                'title' => $record['Title'] ?? '',
                'author' => $record['Author'] ?? '',
                'author_lf' => $record['Author l-f'] ?? '',
                'additional_authors' => $record['Additional Authors'] ?? '',
                'isbn' => $record['ISBN'] !== '' ? preg_replace('/[^A-Za-z0-9\-]/', '', $record['ISBN']) : '',
                'isbn13' => $record['ISBN13'] !== '' ? preg_replace('/[^A-Za-z0-9\-]/', '', $record['ISBN13']) : '',
                'my_rating' => $record['My Rating'] ?? null,
                'average_rating' => $record['Average Rating'] ?? null,
                'publisher' => $record['Publisher'] !== '' ? $record['Publisher'] : null,
                'binding' => $record['Binding'] !== '' ? $record['Binding'] : null,
                'number_of_pages' => $record['Number of Pages'] !== '' ? $record['Number of Pages'] : null,
                'year_published' => $record['Year Published'] !== '' ? $record['Year Published'] : null,
                'original_publication_year' => $record['Original Publication Year'] !== '' ? $record['Original Publication Year'] : null,
            ];

            $book = $existingBook ?? Book::create($bookData);

            $personalData = [
                'date_read' => $record['Date Read'] !== '' ? Carbon::createFromFormat('Y/m/d', $record['Date Read'])->format('Y-m-d') : null,
                'date_added' => $record['Date Added'] !== '' ? Carbon::createFromFormat('Y/m/d', $record['Date Added'])->format('Y-m-d') : null,
                'my_review' => $record['My Review'] ?? '',
                'private_notes' => $record['Private Notes'] ?? '',
                'read_count' => $record['Read Count'] ?? 0,
                'owned_copies' => $record['Owned Copies'] ?? 0,
                'bookshelves' => $record['Bookshelves'] !== '' ? $record['Bookshelves'] : null,
                'bookshelves_with_positions' => $record['Bookshelves with positions'] !== '' ? $record['Bookshelves with positions'] : null,
            ];

            $book->users()->attach(Auth::id(), $personalData);

            $bookshelves = explode(', ', $personalData['bookshelves']);
            $bookshelfPositions = explode(', ', $personalData['bookshelves_with_positions']);

            foreach ($bookshelves as $index => $bookshelfName) {
                preg_match('/\(#(\d+)\)/', $bookshelfPositions[$index], $matches);
                $position = $matches[1] ?? null;

                $bookList = Bookshelf::firstOrCreate([
                    'user_id' => Auth::id(),
                    'name' => $bookshelfName,
                ]);

                $bookList->books()->attach($book->id, ['position' => $position]);
            }
        }

        return redirect()->back()->with('success', 'Books imported successfully!');
    }
}
