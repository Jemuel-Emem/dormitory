<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Dormitory List</h2>
        <button class="w-64 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg px-4 py-2" wire:click="$set('showModal', true)">+ Add Dorm</button>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dormitory Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dormitories as $dormitory)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($dormitory->image)
                                <img src="{{ asset('storage/' . $dormitory->image) }}" alt="{{ $dormitory->name }}" class="w-20 h-20 object-cover">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900">{{ $dormitory->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $dormitory->location }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($dormitory->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $dormitory->details }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $dormitory->contact_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst($dormitory->status) }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="editDormitory({{ $dormitory->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                            <button wire:click="confirmDelete({{ $dormitory->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-3 bg-gray-50">
            {{ $dormitories->links() }}
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ $isEditMode ? 'Edit Dormitory' : 'Add New Dormitory' }}</h2>
            <form wire:submit.prevent="{{ $isEditMode ? 'updateDormitory' : 'addDormitory' }}">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Dormitory Name -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Dormitory Name</label>
                        <input type="text" wire:model="name" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter dormitory name" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Location</label>
                        <input type="text" wire:model="location" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter location" />
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Price</label>
                        <input type="number" wire:model="price" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter price" />
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Details -->
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Details</label>
                        <textarea wire:model="details" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter details" rows="3"></textarea>
                        @error('details') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Contact Number</label>
                        <input type="text" wire:model="contact_number" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter contact number" />
                        @error('contact_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-1">Map Link</label>
                        <input type="text" wire:model="map_link" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter map link (optional)" />
                        @error('map_link') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


                    <div class="col-span-2">
                        <label class="block text-gray-600 text-sm font-bold mb-1">Image</label>
                        <input type="file" wire:model="newImage" class="w-full p-2 border border-gray-300 rounded" />
                        @if ($image && !$newImage)
                            <img src="{{ Storage::url($image) }}" alt="Current Image" class="w-20 h-20 mt-2 rounded">
                        @elseif ($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" alt="New Image Preview" class="w-20 h-20 mt-2 rounded">
                        @endif
                        @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


<div class="">
    <label class="block text-gray-600 text-sm font-bold mb-1">Status</label>
    <select wire:model="status" class="w-full p-2 border border-gray-300 rounded">
        <option value="active">Active</option>
        <option value="not active">Not Active</option>
    </select>
    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                <p>Are you sure you want to delete this dormitory?</p>
                <div class="flex justify-end mt-6">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mr-2" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button wire:click="deleteDormitory" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
