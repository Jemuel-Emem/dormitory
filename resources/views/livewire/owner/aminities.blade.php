<div class="p-6">
  <div class="flex justify-end">
      <!-- Add Button -->
    <button wire:click="openModal" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
    Add Amenity
</button>


  </div>
 @if ($modal)
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <form wire:submit.prevent="saveAmenity">
                <h3 class="text-lg font-semibold mb-4">{{ $isEditing ? 'Edit' : 'Add' }} Amenity</h3>

                <div class="mb-3">
                    <label>Name</label>
                    <input wire:model="name" type="text" class="w-full border p-2 rounded" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea wire:model="description" class="w-full border p-2 rounded"></textarea>
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input wire:model="price" type="number" step="0.01" class="w-full border p-2 rounded" required>
                    @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        {{ $isEditing ? 'Update' : 'Save' }}
                    </button>
                    <button type="button" wire:click="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endif

    <!-- Amenities Table -->
    <div class="mt-6 overflow-x-auto bg-white shadow rounded">
        @if (session()->has('message'))
            <div class="bg-green-100 text-green-700 px-4 py-2 mb-2">{{ session('message') }}</div>
        @endif

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Description</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Price</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($amenities as $amenity)
                    <tr>
                        <td class="px-4 py-2">{{ $amenity->name }}</td>
                        <td class="px-4 py-2">{{ $amenity->description }}</td>
                        <td class="px-4 py-2">₱{{ number_format($amenity->price, 2) }}</td>
                        <td class="px-4 py-2">
                          <button wire:click="editAmenity({{ $amenity->id }})" class="text-blue-600 hover:underline">Edit</button>
<button wire:click="deleteAmenity({{ $amenity->id }})" class="text-red-600 hover:underline ml-2">Delete</button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">No amenities added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>
