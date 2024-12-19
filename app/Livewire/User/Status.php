<?php

namespace App\Livewire\User;
use App\Models\Reserve_Slot as ReserveSlot ;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Status extends Component
{
    public function render()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve the reserved slots for the user, eager load the dorm relationship
        $reservations = ReserveSlot::with('dorm')->where('user_id', $user->id)->get();

        // Pass the data to the view
        return view('livewire.user.status', compact('reservations'));
    }

}
