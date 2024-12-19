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
                    <p class="text-gray-600 font-semibold">Price: Php{{ number_format($dormitory->price, 2) }}</p>
                    <p class="text-gray-600">{{ Str::limit($dormitory->details, 100) }}</p>
                    <span><a href="{{ $dormitory->map_link }}" target="_blank" class="text-green-500">View in Map</a></span>


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
</div>
