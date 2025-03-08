<div>
    <select wire:model="selectedBookshelf" class="w-full border rounded-md p-2">
        <option value="">Select a bookshelf</option>
        @foreach ($bookshelves as $bookshelf)
            <option value="{{ $bookshelf->id }}">{{ $bookshelf->name }}</option>
        @endforeach
    </select>

    <button type="button" wire:click="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
        Add to Bookshelf
    </button>
</div>
