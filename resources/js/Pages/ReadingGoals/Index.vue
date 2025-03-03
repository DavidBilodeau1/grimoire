<template>
    <Head title="Reading Goals" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reading Goals
            </h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <Link :href="route('reading-goals.create')" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add New Goal
                </Link>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <Table
                            @sort="handleSort"
                            :columns="['name']"
                            :items="readingGoals" :actions="[
    { route: 'reading-goals.edit', icon: 'fas fa-pen' },
    { name:'reading-goals.delete', icon: 'fas fa-trash' },
]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Table from "@/Components/Table.vue";
import {provide, ref} from "vue";

defineProps({
    readingGoals: {
        type: Array,
    },
});

const sortBy = ref('title'); // Store the column to sort by
const sortDirection = ref('asc'); // Store the sorting direction

provide('sortBy', sortBy);
provide('sortDirection', sortDirection);

const handleSort = (column) => {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = column;
        sortDirection.value = 'asc';
    }

    router.get('/reading-goals', {
        sort_by: sortBy.value,
        sort_direction: sortDirection.value,
    },{
        preserveState: true
    });
};
</script>
