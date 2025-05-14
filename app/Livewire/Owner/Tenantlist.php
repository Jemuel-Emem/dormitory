<?php

namespace App\Livewire\Owner;
use App\Models\Amenities as Amenity;
use App\Models\Reserve_Slot;
use App\Models\Dormitory;
use Livewire\Component;
use Livewire\WithPagination;

class Tenantlist extends Component
{
    use WithPagination;
public $showAmenitiesModal = false;
public $selectedAmenities = [];
    public function render()
    {
        $ownerId = auth()->id(); // Assuming the owner is authenticated

        // Fetch reservations for the dormitories owned by the authenticated owner
        $reservations = Reserve_Slot::whereHas('dorm', function ($query) use ($ownerId) {
            $query->where('user_id', $ownerId); // Filter dormitories by the owner's ID
        })
        ->with(['user', 'dorm']) // Eager load related models
        ->paginate(10);

        return view('livewire.owner.tenantlist', [
            'reservations' => $reservations,
        ]);
    }
public function showAmenities($reservationId)
{
    $reservation = Reserve_Slot::find($reservationId);

    if ($reservation && $reservation->amenities_ids) {
        $amenityIds = json_decode($reservation->amenities_ids, true);
        $this->selectedAmenities = Amenity::whereIn('id', $amenityIds)->get();
    } else {
        $this->selectedAmenities = [];
    }

    $this->showAmenitiesModal = true;
}
    public function approveReservation($reservationId)
    {
        $reservation = Reserve_Slot::find($reservationId);

        if ($reservation) {
            $reservation->status = 'approved';
            $reservation->save();

            session()->flash('message', 'Reservation approved successfully!');
        }
    }

    // public function declineReservation($reservationId)
    // {
    //     $reservation = Reserve_Slot::find($reservationId);

    //     if ($reservation) {
    //         $reservation->status = 'declined';
    //         $reservation->save();

    //         session()->flash('message', 'Reservation declined successfully!');
    //     }
    // }

    public function declineReservation($reservationId)
{
    $reservation = Reserve_Slot::find($reservationId);

    if ($reservation && $reservation->status !== 'declined') {
        $reservation->status = 'declined';
        $reservation->save();


        if ($reservation->dorm) {
            $reservation->dorm->increment('slot', $reservation->slot);
        }

        session()->flash('message', 'Reservation declined and slot restored.');
    }
}

}
