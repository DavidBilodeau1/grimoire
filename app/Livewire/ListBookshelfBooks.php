<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookBookshelf;
use App\Models\Bookshelf;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
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
                });
            }))
            ->columns([
                ImageColumn::make('cover_image')
                    ->height('200px')
                    ->extraAttributes([
                        'style' => 'margin:-12px -40px 0px -16px',
                    ])
                    ->extraImgAttributes([
                        'class' => 'object-cover h-fit rounded-t-xl w-full',
                    ])
                    ->alignJustify()
                    ->url(fn (Book $record): string => route('books.show', ['book' => $record->id])),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('author')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('publisher')->searchable()->sortable(),
            ])->actions([
                Action::make('removeFromBookshelf')
                    ->icon('heroicon-o-trash')
                    ->iconButton()
                    ->tooltip('Remove From Bookshelf')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->bookshelves()->detach($this->bookshelfId);
                        $record->save();
                        Notification::make()
                            ->title('Book removed!')
                            ->success()
                            ->send();
                    })
            ]);
    }
    public function render()
    {
        return view('livewire.list-bookshelf-books');
    }
}
