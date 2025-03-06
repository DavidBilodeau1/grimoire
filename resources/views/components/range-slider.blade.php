<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        x-data="{
            rating: {{ $getState() ?: 0 }},
            maxRating: 5,
            getStarClasses: (index) => {
                const filled = index <= Math.floor(this.rating);
                const halfFilled = index - 0.5 <= this.rating && index > Math.floor(this.rating);
                return {
                    'text-yellow-400': filled || halfFilled,
                    'text-gray-300': !filled && !halfFilled,
                };
            },
        }"
        class="flex items-center"
    >
        @for ($i = 1; $i <= 5; $i++)
            <button
                type="button"
                x-on:click="rating = {{ $i }}"
                x-on:mouseover="rating = {{ $i }}"
                x-on:mouseout="rating = {{ $getState() ?: 0 }}"
                x-bind:class="getStarClasses({{ $i }})"
                class="transition duration-150 ease-in-out focus:outline-none"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            </button>
        @endfor

        <input
            type="hidden"
            x-model="rating"
        {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
        >
    </div>
</x-dynamic-component>
