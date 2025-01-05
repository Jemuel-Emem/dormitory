<?php

namespace App\Livewire\Owner;

use App\Models\Dormitory;
use App\Models\Tenant;
use App\Models\Reserve_Slot;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $dormCount;
    public $tenantCount;
    public $reservationCount;

    public function mount()
    {
        $this->dormCount = Dormitory::where('owner_id', Auth::id())->count();
        $this->tenantCount = Tenant::where('owner_id', Auth::id())->count();
        $this->reservationCount = Reserve_Slot::whereHas('dorm', function ($query) {
            $query->where('owner_id', Auth::id());
        })->count();
    }

    public function render()
    {
        return view('livewire.owner.index', [
            'dormCount' => $this->dormCount,
            'tenantCount' => $this->tenantCount,
            'reservationCount' => $this->reservationCount,
        ]);
    }
}
