<script setup>
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-yellow-100 to-orange-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-md sm:mx-auto">
            <div class="relative px-4 py-10 bg-white shadow-lg rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <img src="/images/grimoire-logo.png" alt="Grimoire Logo" class="mx-auto h-20 w-auto">
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Login to Your Shelf</h1>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input id="email" v-model="form.email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                                </div>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1">
                                    <input id="password" v-model="form.password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-orange-500 hover:bg-orange-600">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-4 text-center">
                        <Link :href="route('register')" class="text-sm font-medium text-orange-600 hover:text-orange-500">
                            Don't have an account? Register
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
