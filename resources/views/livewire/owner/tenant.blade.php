<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Tenant List</h2>
        <button class="w-64 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg px-4 py-2" wire:click="$set('showModal', true)">+ Add Tenant</button>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fullname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Age</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monthly Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $tenant->fullname }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->age }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->phone_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->room_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Php{{ number_format($tenant->monthly_fee, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->due_date }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="editTenant({{ $tenant->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                            <button wire:click="confirmDelete({{ $tenant->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-3 bg-gray-50">
            {{ $tenants->links() }}
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ $isEditMode ? 'Edit Tenant' : 'Add New Tenant' }}</h2>
            <form wire:submit.prevent="{{ $isEditMode ? 'updateTenant' : 'addTenant' }}">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Fullname -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Fullname</label>
                        <input type="text" wire:model="fullname" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter fullname" />
                        @error('fullname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Age -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Age</label>
                        <input type="number" wire:model="age" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter age" />
                        @error('age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Phone Number</label>
                        <input type="text" wire:model="phone_number" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter phone number" />
                        @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Room Number -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Room Number</label>
                        <input type="text" wire:model="room_number" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter room number" />
                        @error('room_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Monthly Fee -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Monthly Fee</label>
                        <input type="number" wire:model="monthly_fee" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter monthly fee" />
                        @error('monthly_fee') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Due Date</label>
                        <input type="date" wire:model="due_date" class="w-full p-2 border border-gray-300 rounded" />
                        @error('due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        type="button"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mr-2"
                        wire:click="$set('showModal', false)">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
                        {{ $isEditMode ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                <p>Are you sure you want to delete this tenant?</p>
                <div class="flex justify-end mt-6">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mr-2" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button wire:click="deleteTenant" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
