<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Dormitory Owners</h1>
        {{-- <button
            type="button"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            wire:click="openModal">
            Add Dormitory Owner
        </button> --}}
    </div>

   <div id="print-section">
     <table class="w-full border-collapse bg-white rounded shadow-lg">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-4 py-2 border text-left">Name</th>
                <th class="px-4 py-2 border text-left">Phone Number</th>
                <th class="px-4 py-2 border text-left">Email</th>
                <th class="px-4 py-2 border text-left">Status</th>
                <th class="px-4 py-2 border text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($owners as $owner)
                <tr>
                    <td class="px-4 py-2 border">{{ $owner->name }}</td>
                    <td class="px-4 py-2 border">{{ $owner->contact_number }}</td>
                    <td class="px-4 py-2 border">{{ $owner->email }}</td>
                    <td class="px-4 py-2 border capitalize">{{ $owner->status }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if ($owner->status === 'pending')
                            <button class="text-green-600 hover:underline font-semibold mr-2" wire:click="approveOwner({{ $owner->id }})">Approve</button>
                            <button class="text-red-600 hover:underline font-semibold" wire:click="declineOwner({{ $owner->id }})">Decline</button>
                        @else
                            <span class="text-gray-500 italic">No actions</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>


    </table>

   </div>
    <div class="flex justify-end mt-4">
        <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">
    Print Owners
</button>

    </div>
    <!-- Modal Section -->
    <div x-data="{ showModal: @entangle('modalVisible') }" x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">{{ $isEdit ? 'Edit' : 'Add' }} Dormitory Owner</h2>
                <button type="button" class="text-gray-500 hover:text-gray-800" @click="showModal = false">&times;</button>
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

    <script>
    function printTable() {
        const printContents = document.getElementById('print-section').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Optional: reload to restore JS interactivity
    }
</script>

</div>
