<?php

namespace App\Livewire;

use App\Models\Book;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Livewire\Component;
class ListBookshelfBooks extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public int $bookshelfId; // Add a public property to store the bookshelfId

    public function mount($bookshelfId)
    {
        $this->bookshelfId = $bookshelfId;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Book::query()->when($this->bookshelfId, function ($query, $bookshelfId) {
                $query->whereHas('bookshelves', function ($q) use ($bookshelfId) {
                    $q->where('bookshelf_id', $bookshelfId);
                    $q->orderBy('book_bookshelf.position', 'asc');
                });
            }))
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('author'),
                Tables\Columns\TextColumn::make('publisher'),
            ])
            ->reorderable('position');
    }

    public function render()
    {
        return view('livewire.list-bookshelf-books');
    }
}
