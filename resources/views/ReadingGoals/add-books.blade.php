<x-app-layout>
    <div class="p-6 text-gray-900 dark:text-gray-100 ">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4">Add Books to Reading Goal</h1>
                <livewire:add-books-to-reading-goal :readingGoal="$readingGoal" />
            </div>
        </div>
    </div>
</x-app-layout>
