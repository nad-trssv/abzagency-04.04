<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $user->name }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-100 p-8">
        <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-2xl">
            <div class="flex items-center space-x-4">
                <img class="w-16 h-16 rounded-full object-cover" src="{{ $user->photo }}" alt="User {{ $user->id }}">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
        
            <div class="mt-6 space-y-2">
                <p><span class="font-medium text-gray-700">Phone:</span> {{ $user->phone }}</p>
                <p><span class="font-medium text-gray-700">Position:</span> {{ $user->position->name }}</p>
            </div>
        
            <div class="mt-6 flex justify-between">
                <a href="{{ route('users.index') }}"
                   class="inline-block px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">
                    Go back
                </a>
            </div>
        </div>        
    </body>
</html>
