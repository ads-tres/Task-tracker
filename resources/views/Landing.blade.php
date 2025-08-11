<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager - Landing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen font-sans flex flex-col">

    <!-- NAVBAR -->
    <header class="flex justify-between items-center px-6 py-4 bg-gray-800 shadow">
        <div class="text-2xl font-bold text-green-400">
            Task
        </div>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-300 hover:text-blue-400">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-gray-300 hover:text-blue-400">Sign Up</a>
        </div>
    </header>    

    <!-- BODY SECTION -->
    <section class="bg-gray-800 text-gray-300 flex-1 flex items-center justify-center">
        <div class="text-2xl font-bold text-green-400">
            Task
        </div>
    </section>

</body>
</html>
