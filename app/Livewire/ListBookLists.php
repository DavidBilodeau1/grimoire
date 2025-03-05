<?php

namespace App\Livewire;
use App\Models\Bookshelf;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ListBookLists extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Bookshelf::query()->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('name'),
            ])
            ->actions([
                Action::make('show')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn (Bookshelf $record): string => route('bookshelves.show', ['bookshelf' => $record])),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(function (Bookshelf $record) {
                        $record->delete();
                        Notification::make()
                            ->title('Bookshelf deleted successfully')
                            ->success()
                            ->send();
                    })
            ]);
    }

    public function render()
    {
        return view('livewire.list-book-lists');
    }
}
