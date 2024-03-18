<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="antialiased">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
            <!-- Display User Profiles -->
            @foreach ($users as $user)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ $user->name }}</h2>
                    <img src="{{ $user->profile->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full mb-4">
                    <p class="text-gray-600 mb-2">{{ Str::limit($user->profile->bio, 100) }}</p>
                    <!-- Display only 30% of bio -->
                    <button class="text-blue-500 hover:underline" onclick="toggleBio('{{ $user->id }}')">See
                        More</button>
                    <div id="bio{{ $user->id }}" class="hidden mt-2"> <!-- Hidden by default -->
                        <p class="text-gray-600 mb-2">{{ $user->profile->bio }}</p>
                        <!-- Display the rest of the bio when toggled -->
                        <p class="text-gray-600 mb-2">Location: {{ $user->profile->location }}</p>
                        <p class="text-gray-600">Website: <a href="{{ $user->profile->website }}"
                                class="text-blue-500 hover:underline">{{ $user->profile->website }}</a></p>
                        <!-- Display user files -->
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold mb-2">User Files</h3>
                            @foreach ($user->userFiles as $file)
                                <div class="flex items-center justify-between">
                                    <p class="text-gray-600">{{ $file->file_path }}</p>
                                    <!-- Add additional file details as needed -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <script>
        function toggleBio(userId) {
            var bioDiv = document.getElementById('bio' + userId);
            if (bioDiv.style.display === 'none' || bioDiv.style.display === '') {
                bioDiv.style.display = 'block';
            } else {
                bioDiv.style.display = 'none';
            }
        }
    </script>


</body>

</html>
