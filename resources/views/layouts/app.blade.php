<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PT Nilosa Rama Buana Production Tracker' }}</title>

    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Livewire Styles --}}
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md py-4 px-12 flex justify-between items-center">
        <h1 class="text-xl font-bold ">PT Nilosa Rama Buana</h1>
        <ul class="flex gap-6 text-sm">
            <li><a href="/" class="hover:text-indigo-500">Home</a></li>
            <li><a href="#contact" class="hover:text-indigo-500">Kontak</a></li>
            <li><a href="#question" class="hover:text-indigo-500">Pertanyaan</a></li>
        </ul>
    </nav>

    {{-- Main content --}}
    <main class="grow container mx-auto py-10 px-4">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-200 py-6 text-center text-sm">
        &copy; {{ date('Y') }} PT Nilosa Rama Buana. Semua hak cipta dilindungi.
    </footer>

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>

</html>