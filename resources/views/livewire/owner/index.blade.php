<div>
    <h2 class="text-2xl font-semibold text-gray-700">Dashboard</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">

        <div class="bg-red-100 text-red-600 shadow-sm rounded-lg p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $dormCount }}</div>
            <h3 class="mt-2 text-lg font-medium">Dormitories</h3>
        </div>

        <div class="bg-green-100 text-green-600 shadow-sm rounded-lg p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $tenantCount }}</div>
            <h3 class="mt-2 text-lg font-medium">Tenants</h3>
        </div>

        <div class="bg-blue-100 text-blue-600 shadow-sm rounded-lg p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $reservationCount }}</div>
            <h3 class="mt-2 text-lg font-medium">Reservations</h3>
        </div>
    </div>
</div>
