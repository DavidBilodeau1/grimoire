<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">
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
                        <p>Settle in with Grimoire, your personal reading sanctuary. Keep track of your literary
                            adventures, from the books you yearn to read to the ones that warmed your heart.</p>
                        <ul class="list-disc space-y-2 pl-6">
                            <li>Create a comforting TBR (To Be Read) list.</li>
                            <li>Write heartfelt reviews and ratings for your cherished books.</li>
                            <li>Discover new stories and bask in the joy of reading.</li>
                            <li>Enjoy a simple, warm, and inviting interface.</li>
                        </ul>
                        <p>Let Grimoire be the keeper of your reading memories.</p>
                    </div>
                    <div class="pt-6 text-base leading-6 font-bold sm:text-lg space-y-4">
                        @if(\Illuminate\Support\Facades\Auth::user())
                            <div>
                                <a href="{{ route('dashboard') }}"
                                   class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600">
                                    Enter Your Reading Nook
                                </a>
                            </div>
                        @else
                            <div v-else class="flex flex-col space-y-4">
                                <a href="{{ route('login')  }}"
                                   class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600">
                                    Login to Your Shelf
                                </a>
                                <a href="{{ route('register') }}"
                                   class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Join the Reading Circle
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
