<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 left-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @livewire('create-book-list')
            </div>
        </div>
    </div>
</x-app-layout>
