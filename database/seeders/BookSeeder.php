<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'isbn' => '9780618260264',
                'isbn13' => '978-0618260264',
                'my_rating' => 5,
                'average_rating' => 4.52,
                'publisher' => 'Houghton Mifflin Harcourt',
                'binding' => 'Paperback',
                'number_of_pages' => 1216,
                'year_published' => 2005,
                'original_publication_year' => 1954,
                'date_read' => '2023-05-15',
                'date_added' => '2023-01-01',
                'bookshelves' => 'Fantasy, Classics',
                'exclusive_shelf' => 'read',
                'my_review' => 'An epic tale of good versus evil.',
                'read_count' => 1,
                'owned_copies' => 1,
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'isbn' => '9780141439518',
                'isbn13' => '978-0141439518',
                'my_rating' => 4,
                'average_rating' => 4.28,
                'publisher' => 'Penguin Classics',
                'binding' => 'Paperback',
                'number_of_pages' => 432,
                'year_published' => 2003,
                'original_publication_year' => 1913,
                'date_read' => '2023-06-20',
                'date_added' => '2023-02-10',
                'bookshelves' => 'Classics, Romance',
                'exclusive_shelf' => 'read',
                'my_review' => 'A witty and charming story.',
                'read_count' => 1,
                'owned_copies' => 1,
            ],
            // Add more books here...
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
