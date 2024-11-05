<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BHD</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @wireUiScripts --}}
    <style>
        .bg-green-light {
            background-color: #F0FFF4; /* Light green */
        }
    </style>
</head>
<body class="bg-green-light">
    @livewireScripts

    <div class="justify-center w-full mx-auto bg-green-200">
        <div x-data="{ open: false }" class="flex flex-col w-full px-8 py-4 mx-auto md:px-12 md:items-center md:justify-between md:flex-row lg:px-32 max-w-7xl">
            <div class="flex flex-row items-center justify-between text-black w-full md:w-auto">
                <a class="inline-flex items-center gap-3 text-xl font-bold tracking-tight text-black rounded" href="/dashboard">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 rounded-full" alt="BHD Logo" />
                    <span class="text-red-600 font-bold">BHD</span>
                </a>
                <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="flex-col items-center flex-grow hidden gap-6 p-4 text-sm font-medium text-gray-700 md:flex md:flex-row lg:gap-10 md:w-auto">
                <a class="hover:text-green-600 focus:outline-none transition-colors" href="#">Home</a>
                <a class="hover:text-green-600 focus:outline-none transition-colors" href="{{route('user.dormitory')}}">Search</a>
                <a class="hover:text-green-600 focus:outline-none transition-colors" href="#">My Favorites</a>


                <form method="POST" action="{{route('logout')}}" class="ml-auto">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 transition-colors">Logout</button>
                </form>
            </nav>
        </div>
    </div>

    <div>
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
