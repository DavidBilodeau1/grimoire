<template>
    <Head title="Books"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <PrimaryButton @click="doImport" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Import
                </PrimaryButton>
            </div>
        </div>
        <Modal :show="doingImport" @close="closeModal" :submit="submit">
                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm ">
                        <form @submit.prevent="submit">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200 bg-gradient-to-br from-yellow-100 to-orange-100">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Import Your Literary Treasures
                                </h3>
                                <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="default-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="p-4 md:p-5 space-y-4">
                                <label for="csv_file" class="block text-gray-700 text-sm font-bold mb-2">CSV File:</label>
                                <input type="file" id="csv_file" @input="form.csv_file = $event.target.files[0]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b bg-gradient-to-br from-yellow-100 to-orange-100">
                                <PrimaryButton type="submit">Import</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
        </Modal>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <SearchInput @search="searchBooks" />
                <Bookshelf :books="books.data" @book-click="showBook" @add-to-list="showAddToListModal" />
                <Pagination :links="books.links" />
            </div>
        </div>
        <AddToListModal :book="selectedBook" :bookLists="bookLists" :show="showModal" @close="showModal = false" @add-to-list="addToList" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3'
import {nextTick, onMounted, provide, ref} from 'vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Bookshelf from '@/Components/Bookshelf.vue';
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pagination from '@/Components/Pagination.vue';
import SearchInput from '@/Components/SearchInput.vue';
import AddToListModal from "@/Components/AddToListModal.vue";

defineProps({
    books: {
        type: Array,
    },
    bookLists: {
        type: Array,
    }
});

const doingImport = ref(false);
const csv_file = ref(null);
const showModal = ref(false);
const selectedBook = ref(null);

const form = useForm({
    csv_file: '',
});

const submit = () => {
    form.post(route('books.do-import'));
};
const doImport = () => {
    doingImport.value = true;

    nextTick(() => csv_file.value.focus());
};

const closeModal = () => {
    doingImport.value = false;

    form.clearErrors();
    form.reset();
};

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

    router.get('/books', {
        sort_by: sortBy.value,
        sort_direction: sortDirection.value,
    },{
        preserveState: true
    });
};

const searchBooks = (query) => {
    router.get('/books', { search: query }, { preserveState: true });
};

const showBook = (book) => {
    router.get(route('books.show', book.id));
};

const showAddToListModal = (book) => {
    selectedBook.value = book;
    showModal.value = true;
};

const addToList = (bookId, bookListId) => {
    router.post(route('books.add-to-list', bookId), { book_list_id: bookListId });

    showModal.value = false;
};

</script>

