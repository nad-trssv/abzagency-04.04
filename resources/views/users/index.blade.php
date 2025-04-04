<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User list</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="mb-4 p-4 text-green-700 bg-green-100 border border-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 text-warning-700 bg-warning-100 border border-warning-400 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    Add new user
                </a>
                <a href="{{ url('/token') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                    Get access token
                </a>
            </div>
            <div class="mb-4 text-sm text-gray-600 flex justify-between items-center">
                <div>
                    <span class="font-medium">Total users:</span> {{ $total_users }}<br>
                    <span class="font-medium">Page:</span> {{ $page }} of  {{ $total_pages }}
                </div>
            
                <div class="text-right">
                    <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                        {{ $count }} users per page
                    </span>
                </div>
            </div>
            <ul class="space-y-6">
                @foreach ($users as $user)
                    <li class="flex items-center space-x-4 border-b pb-4">
                        <img src="{{ $user->photo }}" alt="User {{ $user->id }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <p class="text-gray-600">{{ $user->phone }}</p>
                            <p class="text-gray-600">{{ $user->position->name }}</p>
                            <a href="{{ route('users.show', $user->id) }}"
                                class="inline-block mt-2 px-3 py-1 text-sm text-blue-600 border border-blue-500 rounded-md hover:bg-blue-50 transition">
                                 Details
                             </a>
                        </div>
                    </li>
                @endforeach
            </ul>
    
            <div class="flex justify-center mt-6">
                <a href="{{ $users->nextPageUrl() }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Show more
                </a>
            </div>
        </div>
    </body>
</html>
