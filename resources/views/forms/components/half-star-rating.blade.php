<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
        rating: 0,
        maxRating: {{ $getMaxRating() }},
        getStarClass(index, half = false) {
            const fullStar = index <= this.rating;
            const halfStar = !fullStar && (index - 0.5) <= this.rating;

            return {
                'filament-forms-star-rating-star--full': fullStar,
                'filament-forms-star-rating-star--half': halfStar,
                'filament-forms-star-rating-star--empty': !fullStar && !halfStar,
            };
        },
    }"
        {{ $attributes->class([
            'filament-forms-star-rating flex',
        ]) }}
    >
        <template x-for="index in {{ $getMaxRating() }}" :key="index">
            <div class="relative">
                <button
                    x-on:click="$wire.set('{{ $getStatePath() }}', index)"
                    x-on:mouseover="$dispatch('rating-changed', index)"
                    x-bind:class="getStarClass(index)"
                    type="button"
                >
                    <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                </button>

                <button
                    x-on:click="$wire.set('{{ $getStatePath() }}', index - 0.5)"
                    x-on:mouseover="$dispatch('rating-changed', index - 0.5)"
                    x-bind:class="getStarClass(index, true)"
                    type="button"
                    class="absolute left-0 hidden"
                >
                    <i class="fa-solid fa-star-half" style="color: #FFD43B;"></i>
                </button>
            </div>
        </template>
    </div>
</x-dynamic-component>
