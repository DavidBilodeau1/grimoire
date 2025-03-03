<template>
    <div class="mt-6 flex">
        <ul class="flex items-center m-auto">
            <li v-for="(link, index) in links" :key="index">
                <a v-if="link.url" :href="`${link.url}&sort_by=${sortBy}&sort_direction=${sortDirection}`" :disabled="!link.url" class="mx-1 px-3 py-2 rounded-md text-sm font-medium" :class="{ 'bg-gray-200': link.active, 'hover:bg-gray-100 cursor-pointer': !link.active }">{{ decodeHtml(link.label) }}</a>
                <span class="mx-1 px-3 py-2 rounded-md text-sm font-medium" v-else>{{ decodeHtml(link.label) }}</span>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { inject } from 'vue';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});

const sortBy = inject('sortBy');
const sortDirection = inject('sortDirection');

function decodeHtml(html) {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}
</script>
