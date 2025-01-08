<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Monthly Bills</h2>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fullname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monthly Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $tenant->fullname }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->room_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Php {{ number_format($tenant->monthly_fee, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($tenant->due_date)->format('jS') }} of the month</td>
                        <td class="px-6 py-4 text-sm text-gray-500 flex space-x-2">

                            <button
                                wire:click="markAsPaid({{ $tenant->id }})"
                                class="px-3 py-1 rounded
                                    {{ $tenant->monthlyPayment && $tenant->monthlyPayment->status === 'paid' ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600 text-white' }}"
                                {{ $tenant->monthlyPayment && $tenant->monthlyPayment->status === 'paid' ? 'disabled' : '' }}>
                                Paid
                            </button>


                            <button
                                wire:click="markAsOverdue({{ $tenant->id }})"
                                class="px-3 py-1 rounded
                                    {{ $tenant->monthlyPayment && $tenant->monthlyPayment->status === 'overdue' ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600 text-white' }}"
                                {{ $tenant->monthlyPayment && $tenant->monthlyPayment->status === 'overdue' ? 'disabled' : '' }}>
                                Overdue
                            </button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No monthly bills found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
