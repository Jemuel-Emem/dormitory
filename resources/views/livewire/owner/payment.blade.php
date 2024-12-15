<div class="p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Monthly Bills</h2>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fullname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monthly Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $tenant->fullname }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->room_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Php {{ number_format($tenant->monthly_fee, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($tenant->due_date)->format('jS') }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No monthly bills found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
