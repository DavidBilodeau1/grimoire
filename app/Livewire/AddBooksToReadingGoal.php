<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\ReadingGoal;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class AddBooksToReadingGoal extends Component implements HasForms
{
    use InteractsWithForms;

    public ReadingGoal $readingGoal;
    public $data = [];

    public function mount(ReadingGoal $readingGoal): void
    {
        $this->readingGoal = $readingGoal;
        $this->form->fill([
            'tags' => $readingGoal->tags->mapWithKeys(function ($tag) {
                return [$tag->id => [
                    'tag_id' => $tag->id,
                    'books' => $tag->books->map(function ($book) {
                        return ['book_id' => $book->id]; // Wrap book_id in an array
                    })->toArray(),
                ]];
            })->toArray(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Repeater::make('tags')
                            ->schema([
                                Select::make('tag_id')
                                    ->label('Tag')
                                    ->options(function () {
                                        return $this->readingGoal->tags->pluck('name', 'id');
                                    }),
                                Repeater::make('books')
                                    ->schema([
                                        Select::make('book_id')
                                            ->label('Book')
                                            ->options(Book::all()->pluck('title', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                    ])
                                    ->collapsible()
                                    ->createItemButtonLabel('Add Book'),
                            ])
                            ->disableLabel(),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        foreach ($this->data['tags'] as $tagData) {
            $tag = $this->readingGoal->tags()->find($tagData['tag_id']);
            $tag->books()->sync($tagData['books']);
        }

        Notification::make()
            ->title('Books added to reading goal!')
            ->success()
            ->send();
        redirect()->route('reading-goals.index');
    }

    public function render()
    {
        return view('livewire.add-books-to-reading-goal');
    }
}
