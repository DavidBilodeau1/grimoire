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
                                <vue3-tags-input :tags="tags"
                                                 placeholder="enter some tags"
                                                 @tags-changed="handleChangeTag"/>
                            </div>

                            <PrimaryButton type="submit">Create</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { defineComponent, ref } from 'vue';
import {Head, useForm} from '@inertiajs/vue3';
import Vue3TagsInput from "@sipec/vue3-tags-input";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default defineComponent({
    name: 'BasicExample',

    components: {
        Head,
        Vue3TagsInput,
        AuthenticatedLayout,
        PrimaryButton,
    },

    setup() {
        const tags = ref([]);
        const form = useForm({
            name: '',
            tags: [],
        });

        const submit = () => {
            form.tags = tags.value;
            form.post(route('reading-goals.store'));
        };

        return { form, submit, tags };
    },

    data() {
        return {
            tags: []
        }
    },

    methods: {
        handleChangeTag(tags) {
            this.tags = tags;
        },
    },
});
</script>
