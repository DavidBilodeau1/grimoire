<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/3 mb-4 md:mb-0">
            @if ($book->cover_image)
                <img src="{{ $book->cover_image }}" alt="{{ $book->title }} Cover" width="200px" class="h-auto rounded-lg shadow-md">
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg shadow-md"></div>
            @endif
        </div>
        <div class="md:w-2/3 md:pl-8">
            <h1 class="text-3xl font-bold mb-4">{{ $book->title }}</h1>
            <p class="text-gray-600 mb-2">by {{ $book->author }}</p>

            <div class="flex items-center mb-4">
                <!--x-filament::forms.components.star-rating :rating="$book->average_rating" disabled /-->
                <span class="ml-2 text-gray-600">({{ $book->average_rating }} average rating)</span>
            </div>

            <p class="mb-6">{{ $book->description ?? '' }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="font-bold mb-2">ISBN:</p>
                    <p>{{ $book->isbn }}</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Publisher:</p>
                    <p>{{ $book->publisher }}</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Published:</p>
                    <p>{{ $book->published_date }}</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Pages:</p>
                    <p>{{ $book->page_count }}</p>
                </div>
            </div>

            <div class="mt-8">
                <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add to Bookshelf
                </a>
            </div>
        </div>
    </div>
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Ratings and Reviews</h2>

            <div class="flex items-center mb-4">
                <x-star-rating :rating="$book->average_rating"  disabled />
            </div>

            @if ($book->users()->count() > 0)
                <div class="space-y-4">
                    @foreach ($book->users()->get() as $bookUser)
                        @if ($bookUser->getOriginal('pivot_my_rating') || $bookUser->getOriginal('pivot_my_review'))
                            <div class="border-t pt-4">
                                <div class="flex items-center mb-2">
                                    <span class="font-semibold">{{ $bookUser->name }} says...</span>
                                    <!--x-filament::forms.components.star-rating :rating="$bookUser->getOriginal('pivot_my_rating')" disabled class="ml-2" /-->
                                    <x-star-rating :rating="$bookUser->getOriginal('pivot_my_rating')"  disabled />

                                </div>
                                <p>{!! $bookUser->getOriginal('pivot_my_review') !!}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p>No reviews yet.</p>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
