<div class="container mx-auto py-6">

    @if($reservations->isEmpty())
        <p class="text-center text-gray-500">You have no reservations.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reservations as $reservation)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group transform hover:scale-105 transition duration-300 ease-in-out">

                    <div class="p-6">
                        {{-- <h3 class="text-lg font-semibold text-gray-800 mb-3">Reservation ID: {{ $reservation->id }}</h3> --}}

                        <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>

                        <p class="text-gray-600 mb-2"><strong>Slots Reserved:</strong> {{ $reservation->slot }}</p>

                        <p class="text-gray-500 mb-4"><strong>Reserved At:</strong> {{ $reservation->created_at->format('F j, Y, g:i a') }}</p>

                        <p class="text-gray-500 text-sm"><strong>Updated At:</strong> {{ $reservation->updated_at->format('F j, Y, g:i a') }}</p>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
