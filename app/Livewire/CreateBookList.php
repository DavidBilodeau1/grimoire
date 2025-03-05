<?php

namespace App\Livewire;

use App\Models\Bookshelf;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class CreateBookList extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $bookshelf = null;

    public function mount($bookshelf = null): void
    {
        $this->bookshelf = $bookshelf;
        $this->form->fill([
            'name' => $bookshelf?->name,
        ]);
    }

    public function form(Form $form)
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ])
            ->statePath('data');
    }

    public function save()
    {
        if ($this->bookshelf) {
            $this->bookshelf->update($this->data);
        } else {
            $this->data['user_id'] = auth()->id();
            $this->bookshelf = Bookshelf::create($this->data);
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

        redirect()->route('bookshelves.index');
    }

    public function render()
    {
        return view('livewire.create-book-list');
    }
}
