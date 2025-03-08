<?php

namespace App\Livewire;

use App\Http\Controllers\BookController;
use App\Models\Bookshelf;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BookshelfSelection extends Component
{
    public $book;
    public $selectedBookshelf;

    public function mount($book)
    {
        $this->book = $book;
    }

    public function submit()
    {
        // Make API call to add the book to the selected bookshelf
        $response = BookController::apiAddToBookshelf($this->book, $this->selectedBookshelf);

        // Handle the API response
        if ($response->getStatusCode() == 200) {
            // Close the modal
            $this->dispatch('closeModal', 'bookshelf-selection');
            // Optionally, display a success message
            Notification::make()
                ->title('Book added to bookshelf!')
                ->success()
                ->send();
        } else {
            // Handle errors
            Notification::make()
                ->title('Error while adding book to bookshelf: ' . $response->getContent())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.bookshelf-selection', [
            'bookshelves' => Bookshelf::where('user_id', Auth::id())->get(), // Fetch the user's bookshelves
        ]);
    }
}
