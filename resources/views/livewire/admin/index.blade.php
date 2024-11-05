<div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

    <div class="bg-white shadow-lg rounded-lg p-6 flex items-center justify-between transition-transform transform hover:scale-105">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $dormitoryCount }}</h2>
            <p class="text-gray-500">Total Dormitories</p>
        </div>
        <div class="bg-green-100 p-4 rounded-full">
            <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M4 7h16M6 9v10m12-10v10M9 21h6M9 3h6m4 0a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1h14z"/>
            </svg>
        </div>
    </div>


    <div class="bg-white shadow-lg rounded-lg p-6 flex items-center justify-between transition-transform transform hover:scale-105">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $userCount }}</h2>
            <p class="text-gray-500">Total Users</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-full">
            <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10m-9 4h8m5 1.5v3M5 17.5v3M3 21h18M3 3l18 18"/>
            </svg>
        </div>
    </div>
</div>
