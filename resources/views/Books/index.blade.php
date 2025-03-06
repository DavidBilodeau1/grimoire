<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library') }}
        </h2>
    </x-slot>
    <div class="pt-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-filament::modal>
            <x-slot name="trigger">
                <x-filament::button>
                    Import books
                </x-filament::button>
            </x-slot>

            <div class="relative w-full max-w-2xl max-h-full">
                @livewire('import-books')
            </div>
        </x-filament::modal>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('list-books')
            </div>
        </div>
    </div>
</x-app-layout>
