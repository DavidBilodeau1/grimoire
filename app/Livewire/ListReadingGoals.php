<?php

namespace App\Livewire;

use App\Models\ReadingGoal;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListReadingGoals extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ReadingGoal::query()->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
            ])
            ->actions([
                Action::make('books')
                    ->icon('heroicon-o-bookmark-square')
                    ->color('info')
                    ->url(fn (ReadingGoal $record): string => route('reading-goals.add-books', ['reading_goal' => $record])),
                Action::make('edit')
                    ->icon('heroicon-o-pencil')
                    ->color('regular')
                    ->url(fn (ReadingGoal $record): string => route('reading-goals.edit', ['reading_goal' => $record])),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(fn (ReadingGoal $record) => $record->delete())
            ]);
    }

    public function render()
    {
        return view('livewire.list-reading-goals');
    }
}
