<?php

namespace App\Livewire;

use App\Http\Controllers\BookController;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class ImportBooks extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form)
    {
        return $form
            ->schema([
                FileUpload::make('file')->acceptedFileTypes(['text/csv','txt'])
                ->multiple(false)
            ])
            ->statePath('data');
    }

    public function import(): void
    {
        foreach ($this->data['file'] as $file) {
            BookController::doImport($file);
        }

        redirect()->route('books');

        // Optionally, display a success message or redirect
        Notification::make()
            ->title('Books imported successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.import-books');
    }
}
