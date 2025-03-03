<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-yellow-100 to-orange-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="relative px-4 py-10 bg-white shadow-lg rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <img src="/images/grimoire-logo.png" alt="Grimoire Logo" class="mx-auto h-20 w-auto">
                    </div>
                    <div>
                        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-2">Welcome to Grimoire</h1>
                        <p class="mt-2 text-center text-gray-600 leading-relaxed">Your cozy corner for book management.</p>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-relaxed space-y-4 text-gray-700 sm:text-lg">
                            <p>Settle in with Grimoire, your personal reading sanctuary. Keep track of your literary adventures, from the books you yearn to read to the ones that warmed your heart.</p>
                            <ul class="list-disc space-y-2 pl-6">
                                <li>Create a comforting TBR (To Be Read) list.</li>
                                <li>Write heartfelt reviews and ratings for your cherished books.</li>
                                <li>Discover new stories and bask in the joy of reading.</li>
                                <li>Enjoy a simple, warm, and inviting interface.</li>
                            </ul>
                            <p>Let Grimoire be the keeper of your reading memories.</p>
                        </div>
                        <div class="pt-6 text-base leading-6 font-bold sm:text-lg space-y-4">
                            <div v-if="$page.props.auth.user">
                                <Link :href="route('dashboard')" class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600">
                                    Enter Your Reading Nook
                                </Link>
                            </div>
                            <div v-else class="flex flex-col space-y-4">
                                <Link :href="route('login')" class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600">
                                    Login to Your Shelf
                                </Link>
                                <Link :href="route('register')" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Join the Reading Circle
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
