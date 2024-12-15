<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant; // Assuming your model name is Tenant

class Payment extends Component
{
    public $tenants;

    public function mount()
    {
        // Fetch tenants for the logged-in owner
        $this->tenants = Tenant::where('owner_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.owner.payment', [
            'tenants' => $this->tenants,
        ]);
    }
}
