<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('books')  }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            {{ __('Return to list') }}
        </a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="w-1/4 mr-4">
                            <img width="200px" src="{{ $book->cover_image }}" alt="Book Cover" class="h-auto">
                        </div>
                        <div class="w-3/4">
                            <p class="mb-2"><strong>Author:</strong> {{ $book->author }}</p>
                            <p class="mb-2"><strong>Average Rating:</strong> {{ $book->average_rating }}</p>
                            <p class="mb-2"><strong>Publisher:</strong> {{ $book->publisher }}</p>
                            <p class="mb-2"><strong>Year Published:</strong> {{ $book->year_published }}</p>
                            <p class="mb-2"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p class="mb-2"><strong>Title:</strong> {{ $book->title}}</p>
                        </div>
                    </div>
                    @if ($userBookInfo)
                        <div>
                            <div>
                                <h3>Your Information</h3>
                                <p>Date Read: {{ $userBookInfo->date_read }}</p>
                                <p>Date Added: {{ $userBookInfo->date_added }}</p>
                                <p>My Review: {{ $userBookInfo->my_review }}</p>
                                <p>Private Notes: {{ $userBookInfo->private_notes }}</p>
                                <p>Owned Copies: {{ $userBookInfo->owned_copies }}</p>
                                <p>Bookshelves: {{ $userBookInfo->bookshelves_with_positions }}</p>
                                <p>Number of times read: {{ $userBookInfo->read_count }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
