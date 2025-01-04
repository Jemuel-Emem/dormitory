<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Reservation List</h2>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tenant Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dormitory</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reservations as $reservation)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->user->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $reservation->user->email ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $reservation->dorm->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm capitalize text-gray-500">{{ $reservation->status ?? 'Pending' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <!-- Approve Button -->
                                <button
                                    wire:click="approveReservation({{ $reservation->id }})"
                                    class="px-4 py-2 rounded
                                        {{ $reservation->status === 'approved' || $reservation->status === 'declined' ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-green-500 text-white hover:bg-green-600' }}"
                                    {{ $reservation->status === 'approved' || $reservation->status === 'declined' ? 'disabled' : '' }}
                                >
                                    Approve
                                </button>

                                <!-- Decline Button -->
                                <button
                                    wire:click="declineReservation({{ $reservation->id }})"
                                    class="px-4 py-2 rounded
                                        {{ $reservation->status === 'approved' || $reservation->status === 'declined' ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-red-500 text-white hover:bg-red-600' }}"
                                    {{ $reservation->status === 'approved' || $reservation->status === 'declined' ? 'disabled' : '' }}
                                >
                                    Decline
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-600">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-3 bg-gray-50">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
