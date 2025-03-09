<?php

namespace App\Livewire;

use App\Forms\Components\HalfStarRating;
use App\Models\Book;
use App\Models\Bookshelf;
use App\Models\BookUser;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Livewire\Component;

class ListBooks extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Book::query())
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Grid::make()
                        ->schema([
                            Tables\Columns\Layout\Grid::make()
                                ->schema([
                                    ImageColumn::make('cover_image')
                                        ->height('200px')
                                        ->extraAttributes([
                                            'style' => 'margin:-12px -40px 0px -16px',
                                        ])
                                        ->extraImgAttributes([
                                            'class' => 'object-cover h-fit rounded-t-xl w-full',
                                        ])
                                        ->defaultImageUrl(url('/images/placeholder.gif'))
                                        ->alignJustify()
                                ])
                                ->columns(1)
                                ->columnStart(2),

                            Tables\Columns\Layout\Grid::make()
                                ->schema([
                                    Tables\Columns\TextColumn::make('title')
                                        ->sortable()
                                        ->searchable(),
                                    Tables\Columns\TextColumn::make('author')
                                        ->sortable()
                                        ->searchable(),
                                    Tables\Columns\TextColumn::make('average_rating')
                                        ->sortable()
                                ])
                                ->extraAttributes([
                                    'style' => 'display:none'
                                ])
                                ->columns(1)
                                ->columnStart(2),
                        ])
                        ->columns(3),
                ]),
            ])
            ->defaultSort('title','asc')
            ->contentGrid([
                'md' => 4,
                'xl' => 4,
                '2xl' => 4,
            ])
            ->recordUrl(fn (Book $record): string => route('books.show', ['book' => $record]))
            ->actions(
                ActionGroup::make([
                    Action::make('addToBookshelf')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->form([
                        Select::make('bookshelfId')
                            ->label('Bookshelf')
                            ->options(Bookshelf::query()->pluck('name', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data, Book $record): void {
                        $record->bookshelves()->attach($data['bookshelfId']);
                        $record->save();
                        Notification::make()
                            ->title('Book added!')
                            ->success()
                            ->send();
                    }),
                    Action::make('RateAndReview')
                    ->icon('heroicon-o-sparkles')
                    ->form([
                        HalfStarRating::make('my_rating')
                            ->maxRating(5)
                            ->dehydrated(false),
                        RichEditor::make('my_review'),
                        Checkbox::make('spoiler'),
                        RichEditor::make('private_notes'),
                    ])
                    ->action(function (array $data, Book $record): void {
                        $bookUser = new BookUser();
                        $bookUser->fill([
                            'user_id' => auth()->id(),
                            'book_id' => $record->id,
                            'my_review' => $data['my_review'],
                            'my_rating' => $data['my_rating'],
                            'spoiler' => $data['spoiler'],
                            'private_notes' => $data['private_notes'],
                        ]);
                        $bookUser->save();
                        $record->users()->attach($bookUser->id);
                        $record->save();
                        Notification::make()
                            ->title('Review added!')
                            ->success()
                            ->send();
                    }),
                    Action::make('updateProgress')
                    ->icon('heroicon-o-check-badge')
                    ->form([
                        TextInput::make('progress')
                            ->numeric()
                            ->inputMode('decimal'),
                    ])
                    ->action(function (array $data, Book $record): void {
                        $bookUser = new BookUser();
                        $bookUser->fill([
                            'user_id' => auth()->id(),
                            'book_id' => $record->id,
                            'progress' => $data['progress'],
                        ]);
                        $bookUser->save();
                        $record->users()->attach($bookUser->id);
                        $record->save();
                        Notification::make()
                            ->title('Progress saved!')
                            ->success()
                            ->send();
                    })
                ])
            )
            ->deferLoading(true);
    }

    public function render()
    {
        return view('livewire.list-books');
    }
}
