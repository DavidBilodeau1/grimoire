<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="My Bookshelf" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold text-gray-800">
                Welcome to Your Reading Nook
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <p class="text-gray-700 leading-relaxed">
                        Settle in and explore your reading world. Here, you can manage your books, track your progress, and discover new literary adventures.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
