<div x-data="{
    searchTimeout: null,
    handleInput(event) {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            if (event.target.value != '') {
                 @this.updateQuery(event.target.value);
            }
        }, 200);
    },
}"
     class="relative w-1/2"
>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg style=";" wire:loading.remove.delay.default="1" class="fi-input-wrp-icon h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"></path>
            </svg>
            <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-input-wrp-icon h-5 w-5 text-gray-400 dark:text-gray-500" wire:loading.delay.default="">
                <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
            </svg>
        </div>
        <input type="text" x-on:input="handleInput" placeholder="Search for books..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    </div>
    @if (!empty($results))
        <ul class="absolute z-10 bg-white border rounded-md mt-0 w-full">
            @foreach ($results as $result)
                <li class="p-2 hover:bg-gray-100 cursor-pointer" wire:click="selectBook(`{{ json_encode($result) }}`)">
                    {{ $result['title'] .  ($result['authors'] ? ' - ' . $result['authors'] : '') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
