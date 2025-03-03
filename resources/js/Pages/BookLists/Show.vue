<template>
    <Head title="Books"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Bookshelf :books="books.data" @book-click="showBook" />
                <Pagination :links="books.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3'
import {provide, ref} from 'vue';
import {Head} from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Pagination from '@/Components/Pagination.vue';
import Bookshelf from "@/Components/Bookshelf.vue";

defineProps({
    books: {
        type: Object,
    },
    bookLists: {
        type: Array,
    },
    bookList: {
        type: Object,
        default: null, // Add a default value for when it's not a book list view
    },
});

const sortBy = ref('title'); // Store the column to sort by
const sortDirection = ref('asc'); // Store the sorting direction

provide('sortBy', sortBy);
provide('sortDirection', sortDirection);

const handleSort = (column, bookList) => {
    const routeName = bookList?.id ? route('book-lists.show', bookList.id) : route('books');

    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = column;
        sortDirection.value = 'asc';
    }

    router.get(routeName, {
        sort_by: sortBy.value,
        sort_direction: sortDirection.value,
    },{
        preserveState: true
    });
};

const showBook = (book) => {
    router.get(route('books.show', book.id));
};

</script>

