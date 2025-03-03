<template>
    <Head title="Create Reading Goal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Reading Goal
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" id="name" v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4">
                                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags:</label>
                                <vue-tags-input element-id="tags" v-model="form.tags" :existing-tags="existingTags" @tag-added="addTag" />
                            </div>

                            <PrimaryButton type="submit">Create</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import VueTagsInput from "@sipec/vue3-tags-input";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: '',
    tags: [],
});

let existingTags = [];

const addTag = (newTag) => {
    existingTags.push(newTag);
    existingTags = [...new Set(existingTags)];
};

const submit = () => {
    form.tags = tags;
    form.post(route('reading-goals.store'));
};
</script>
