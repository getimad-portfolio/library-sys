<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page Not Found</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grid place-items-center h-screen w-screen bg-gray-50">
        <div class="flex flex-col items-center gap-6">
            <h1 class="text-7xl font-bold">404 - Page Not Found</h1>
            <p class="text-slate-500">Sorry, the page you are looking for does not exist.</p>
            <a class="bg-white p-3 rounded-md font-semibold border hover:bg-gray-100 transition-colors duration-300 ease-in-out flex gap-2 items-center" href="{{ url('/') }}">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                
                Go back to Home
            </a>
        </div>
    </body>
</html>