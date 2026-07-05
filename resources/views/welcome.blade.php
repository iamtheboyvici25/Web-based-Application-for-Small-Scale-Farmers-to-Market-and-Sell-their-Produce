<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web App For Smallholder Farmers</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">
    
    <nav class="w-full p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <span class="text-3xl">🌾</span>
            <span class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">Web App For Smallholder Farmers</span>
        </div>
        
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition shadow-sm">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <main class="flex-grow flex items-center justify-center flex-col text-center px-6 py-12">
        <div class="max-w-3xl space-y-8">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                  Fresh Produce from <span class="text-emerald-600 dark:text-emerald-400">Kiambu</span> to Nairobi.
            </h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300">
                 A web application that connects smallholder farmers in Kiambu with buyers in Nairobi, enabling them to sell their fresh produce directly to consumers and businesses.
            </p>
            
            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold rounded-full transition shadow-lg flex items-center gap-2">
                    <span>Start Buying & Selling</span> 🚀
                </a>
            </div>
        </div>

        <div class="mt-12 text-4xl md:text-5xl flex gap-6 opacity-80">
            🍅 🥬 🌽 🥕 🥔
        </div>

        <div class="mt-16 w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Need Assistance?</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Our platform administrator is here to help you.</p>
            
            <div class="flex flex-col gap-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                <div class="flex items-center justify-center gap-2">
                    <span class="text-lg">📞</span> <span>+254 700 000 000</span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-lg">✉️</span> <a href="mailto:admin@classifieds.com" class="hover:text-emerald-600 transition">admin@classifieds.com</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full p-6 text-center text-sm text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} Web App for Smallholder Farmers.
    </footer>
</body>
</html>