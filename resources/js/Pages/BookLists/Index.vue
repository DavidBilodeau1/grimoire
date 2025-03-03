<template>
    <Head title="My Reading Lists" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Bookshelves
            </h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <Link :href="route('book-lists.create')" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add New Shelf
                </Link>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <Table :columns="['name','is_main']" :items="bookLists" :actions="[
    { route: 'book-lists.show', icon: 'fas fa-eye' },
    { route: 'book-lists.edit', icon: 'fas fa-edit' },
    { route: 'book-lists.destroy', icon: 'fas fa-trash' }
]" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import {Link} from '@inertiajs/vue3';

defineProps({
    bookLists: {
        type: Array,
    },
});
</script>

