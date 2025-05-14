<div class="p-4">
    <div class="mb-4 flex flex-col sm:flex-row">
        <input type="text" wire:model.defer="searchLocation" placeholder="Search by location" class="p-2 border border-gray-300 rounded w-full sm:w-1/3 mb-2 sm:mb-0 sm:mr-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
        <input type="number" wire:model.defer="searchPrice" placeholder="Max price" class="p-2 border border-gray-300 rounded w-full sm:w-1/3 mb-2 sm:mb-0 sm:mr-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
        <button wire:click="search" class="bg-green-500 w-full sm:w-32 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
            Search
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($dormitories->count())
            @foreach($dormitories as $dormitory)

            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                <img src="{{ asset('storage/' . $dormitory->image) }}" alt="{{ $dormitory->name }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800 hover:text-green-500 transition-colors">{{ $dormitory->name }}</h3>
                    <p class="text-gray-600">{{ $dormitory->location }}</p>
                   <p class="text-gray-600">Availability:  {{ $dormitory->slot }} Slot</p>
                    <p class="text-gray-600 font-semibold">Price: Php{{ number_format($dormitory->price, 2) }}</p>
                    <p class="text-gray-600">Details:  {{ Str::limit($dormitory->details, 100) }}</p>

                    <span><a href="{{ $dormitory->map_link }}" target="_blank" class="text-green-500">View in Map</a></span>
                    <button wire:click="showComments({{ $dormitory->id }})" class="text-blue-400 mt-2">
                        Comments
                    </button>

                    <div class="mt-4">
                        <button wire:click="reserve({{ $dormitory->id }})" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                            Reserve Slot
                        </button>
                    </div>
                </div>
            </div>


            @endforeach
        @else
            <div class="col-span-full text-center p-4">
                <p class="text-gray-600">No data found.</p>
            </div>
        @endif
    </div>

    <div class="mt-4">
        {{ $dormitories->links() }}
    </div>

    @if ($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/2 lg:w-1/3">
            <h2 class="text-lg font-semibold mb-4">Comments for {{ $selectedDormitoryName }}</h2>
            <div class="overflow-y-auto max-h-60">
                @if ($comments && count($comments) > 0)
                    @foreach ($comments as $comment)
                        <div class="border-b border-gray-300 pb-2 mb-2">
                            <p class="text-gray-800 font-semibold">{{ $comment->user->name ?? 'Anonymous' }}</p>
                            <p class="text-gray-600">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">No comments available.</p>
                @endif
            </div>

            <!-- Add Comment Form -->
            <form wire:submit.prevent="addComment" class="mt-4">
                <textarea wire:model.defer="newComment" placeholder="Write a comment..." class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                @error('newComment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded mt-2">
                    Add Comment
                </button>
            </form>

            <div class="mt-4">
                <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mr-2">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif

    @if ($reserveSlotModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/2 lg:w-1/3">
        <h2 class="text-lg font-semibold mb-4">Reserve Slot</h2>
@if ($selectedAmenities)
    <div class="mt-4">
        <label class="block font-semibold mb-2">Select Amenities to Include:</label>
        @foreach ($selectedAmenities as $amenity)
            <label class="flex items-center space-x-2 mb-2">
               <input type="checkbox" value="{{ $amenity->id }}" wire:model="includedAmenities" class="form-checkbox text-green-500">

                <span class="text-gray-700">
                    {{ $amenity->name }} - <span class="text-sm text-gray-500">Php{{ number_format($amenity->price, 2) }}</span>
                </span>
            </label>
        @endforeach
    </div>
@endif


        <div>
            <label class="block mb-2 font-semibold">Number of Slots (Max: {{ $selectedDormSlot }})</label>
            <input type="number" wire:model.defer="inputSlot" min="1" :max="{{ $selectedDormSlot }}" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('inputSlot') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4 flex justify-end space-x-2">
            <button wire:click="$set('reserveSlotModal', false)" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">Cancel</button>
            <button wire:click="confirmReservation" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">Confirm</button>
        </div>
    </div>
</div>
@endif

</div>
