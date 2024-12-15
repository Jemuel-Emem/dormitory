<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Dormitory Owners</h1>
        <button
            type="button"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            wire:click="openModal">
            Add Dormitory Owner
        </button>
    </div>

    <table class="w-full border-collapse bg-white rounded shadow-lg">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-4 py-2 border text-left">Name</th>

                <th class="px-4 py-2 border text-left">Phone Number</th>

                <th class="px-4 py-2 border text-left">Email</th>

                <th class="px-4 py-2 border text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($owners as $owner)
                <tr>
                    <td class="px-4 py-2 border">{{ $owner->name }}</td>

                    <td class="px-4 py-2 border">{{ $owner->contact_number }}</td>

                    <td class="px-4 py-2 border">{{ $owner->email }}</td>
                    <td class="px-4 py-2 border text-center">
                        <button class="text-blue-500 hover:underline" wire:click="editOwner({{ $owner->id }})">Edit</button> |
                        <button class="text-red-500 hover:underline" wire:click="deleteOwner({{ $owner->id }})" onclick="return confirm('Are you sure?');">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div x-data="{ showModal: @entangle('modalVisible') }" x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">{{ $isEdit ? 'Edit' : 'Add' }} Dormitory Owner</h2>
                <button
                    type="button"
                    class="text-gray-500 hover:text-gray-800"
                    @click="showModal = false">
                    &times;
                </button>
            </div>
            <form wire:submit.prevent="{{ $isEdit ? 'updateOwner' : 'saveOwner' }}">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="contact_number" wire:model.defer="contact_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
                @if (!$isEdit)
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                @endif
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2" @click="showModal = false">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">{{ $isEdit ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
