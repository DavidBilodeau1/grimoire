<?php

namespace App\Livewire;

use App\Models\Book;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
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
                                        ->alignJustify()
                                        ->url(fn (Book $record): string => route('books.show', ['book' => $record])),
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
            ->deferLoading(false);
    }

    public function render()
    {
        return view('livewire.list-books');
    }
}
